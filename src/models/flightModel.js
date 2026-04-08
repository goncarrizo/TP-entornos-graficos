const db = require('../config/db');

async function getFlights({ origin, destination, date }) {
  let query = `
    SELECT f.*, a.name AS airline_name,
           p.title AS promo_title, p.discount_percent AS promo_discount
    FROM flights f
    JOIN airlines a ON a.id = f.airline_id
    LEFT JOIN promotions p ON p.airline_id = a.id AND p.status = 'approved' AND p.is_active = 1
    WHERE 1 = 1
  `;
  const params = [];

  if (origin) {
    query += ' AND f.origin = ?';
    params.push(origin);
  }
  if (destination) {
    query += ' AND f.destination = ?';
    params.push(destination);
  }
  if (date) {
    query += ' AND DATE(f.departure_time) = ?';
    params.push(date);
  }

  query += ' ORDER BY f.departure_time ASC';

  const [rows] = await db.execute(query, params);
  return rows;
}

async function getFlightById(id) {
  const [rows] = await db.execute(
    `SELECT f.*, a.name AS airline_name
     FROM flights f
     JOIN airlines a ON a.id = f.airline_id
     WHERE f.id = ?`,
    [id]
  );
  return rows[0] || null;
}

async function createFlight(data) {
  const [result] = await db.execute(
    `INSERT INTO flights
      (airline_id, origin, destination, departure_time, arrival_time, price, total_seats, available_seats)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?)`,
    [
      data.airline_id,
      data.origin,
      data.destination,
      data.departure_time,
      data.arrival_time,
      data.price,
      data.total_seats,
      data.total_seats,
    ]
  );
  return result.insertId;
}

async function updateFlight(id, data) {
  await db.execute(
    `UPDATE flights
     SET airline_id = ?, origin = ?, destination = ?, departure_time = ?, arrival_time = ?, price = ?, total_seats = ?
     WHERE id = ?`,
    [
      data.airline_id,
      data.origin,
      data.destination,
      data.departure_time,
      data.arrival_time,
      data.price,
      data.total_seats,
      id,
    ]
  );
}

async function deleteFlight(id) {
  await db.execute('DELETE FROM flights WHERE id = ?', [id]);
}

async function reduceSeats(flightId, seats) {
  const [result] = await db.execute(
    `UPDATE flights
     SET available_seats = available_seats - ?
     WHERE id = ? AND available_seats >= ?`,
    [seats, flightId, seats]
  );
  return result.affectedRows > 0;
}

async function addSeats(flightId, seats) {
  await db.execute('UPDATE flights SET available_seats = available_seats + ? WHERE id = ?', [seats, flightId]);
}

module.exports = {
  getFlights,
  getFlightById,
  createFlight,
  updateFlight,
  deleteFlight,
  reduceSeats,
  addSeats,
};
