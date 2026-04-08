const db = require('../config/db');

async function salesByAirline() {
  const [rows] = await db.execute(
    `SELECT a.name AS airline, COALESCE(SUM(r.total_amount), 0) AS total_sales
     FROM airlines a
     LEFT JOIN flights f ON f.airline_id = a.id
     LEFT JOIN reservations r ON r.flight_id = f.id AND r.status = 'confirmed'
     GROUP BY a.id
     ORDER BY total_sales DESC`
  );
  return rows;
}

async function occupancyByFlight() {
  const [rows] = await db.execute(
    `SELECT f.id, f.origin, f.destination,
            f.total_seats,
            (f.total_seats - f.available_seats) AS occupied_seats,
            ROUND(((f.total_seats - f.available_seats) / f.total_seats) * 100, 2) AS occupancy_percent
     FROM flights f
     ORDER BY occupancy_percent DESC`
  );
  return rows;
}

async function generalCounts() {
  const [[users]] = await db.execute('SELECT COUNT(*) AS total_users FROM users');
  const [[flights]] = await db.execute('SELECT COUNT(*) AS total_flights FROM flights');
  const [[reservations]] = await db.execute('SELECT COUNT(*) AS total_reservations FROM reservations');
  return { ...users, ...flights, ...reservations };
}

module.exports = { salesByAirline, occupancyByFlight, generalCounts };
