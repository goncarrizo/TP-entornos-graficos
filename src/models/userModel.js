const db = require('../config/db');

async function createUser({ name, email, passwordHash, role = 'customer', emailVerified = 0 }) {
  const [result] = await db.execute(
    'INSERT INTO users (name, email, password_hash, role, email_verified) VALUES (?, ?, ?, ?, ?)',
    [name, email, passwordHash, role, emailVerified]
  );
  return result.insertId;
}

async function findUserByEmail(email) {
  const [rows] = await db.execute('SELECT * FROM users WHERE email = ?', [email]);
  return rows[0] || null;
}

async function findUserById(id) {
  const [rows] = await db.execute('SELECT id, name, email, role, email_verified FROM users WHERE id = ?', [id]);
  return rows[0] || null;
}

async function listUsers() {
  const [rows] = await db.execute('SELECT id, name, email, role, email_verified, created_at FROM users ORDER BY created_at DESC');
  return rows;
}

module.exports = { createUser, findUserByEmail, findUserById, listUsers };
