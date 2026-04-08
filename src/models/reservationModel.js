const db = require('../config/db');

async function createReservation({ userId, flightId, seats, totalAmount, status = 'pending' }) {
  const [result] = await db.execute(
    'INSERT INTO reservations (user_id, flight_id, seats, total_amount, status) VALUES (?, ?, ?, ?, ?)',
    [userId, flightId, seats, totalAmount, status]
  );
  return result.insertId;
}

async function confirmReservation(id) {
  await db.execute('UPDATE reservations SET status = ? WHERE id = ?', ['confirmed', id]);
}

async function findReservationById(id) {
  const [rows] = await db.execute(
    `SELECT r.*, f.departure_time
     FROM reservations r
     JOIN flights f ON f.id = r.flight_id
     WHERE r.id = ?`,
    [id]
  );
  return rows[0] || null;
}

async function getUserReservations(userId) {
  const [rows] = await db.execute(
    `SELECT r.*, f.origin, f.destination, f.departure_time, a.name AS airline_name
     FROM reservations r
     JOIN flights f ON f.id = r.flight_id
     JOIN airlines a ON a.id = f.airline_id
     WHERE r.user_id = ?
     ORDER BY r.created_at DESC`,
    [userId]
  );
  return rows;
}

async function cancelReservation(id) {
  await db.execute('UPDATE reservations SET status = ? WHERE id = ?', ['cancelled', id]);
}

module.exports = {
  createReservation,
  confirmReservation,
  findReservationById,
  getUserReservations,
  cancelReservation,
};
