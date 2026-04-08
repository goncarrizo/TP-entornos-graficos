const db = require('../config/db');

async function getAllAirlines() {
  const [rows] = await db.execute('SELECT * FROM airlines ORDER BY id DESC');
  return rows;
}

async function createAirline({ name, code, country }) {
  const [result] = await db.execute(
    'INSERT INTO airlines (name, code, country) VALUES (?, ?, ?)',
    [name, code, country]
  );
  return result.insertId;
}

async function updateAirline(id, { name, code, country }) {
  await db.execute(
    'UPDATE airlines SET name = ?, code = ?, country = ? WHERE id = ?',
    [name, code, country, id]
  );
}

async function deleteAirline(id) {
  await db.execute('DELETE FROM airlines WHERE id = ?', [id]);
}

module.exports = { getAllAirlines, createAirline, updateAirline, deleteAirline };
