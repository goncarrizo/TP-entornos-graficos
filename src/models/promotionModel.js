const db = require('../config/db');

async function getPromotions() {
  const [rows] = await db.execute(
    `SELECT p.*, a.name AS airline_name
     FROM promotions p
     JOIN airlines a ON a.id = p.airline_id
     ORDER BY p.created_at DESC`
  );
  return rows;
}

async function createPromotion({ airlineId, title, description, discountPercent, isActive = 1 }) {
  if (isActive) {
    // Solo una promocion activa por aerolinea.
    await db.execute('UPDATE promotions SET is_active = 0 WHERE airline_id = ?', [airlineId]);
  }

  const [result] = await db.execute(
    `INSERT INTO promotions (airline_id, title, description, discount_percent, status, is_active)
     VALUES (?, ?, ?, ?, 'pending', ?)`,
    [airlineId, title, description, discountPercent, isActive]
  );
  return result.insertId;
}

async function updatePromotionStatus(id, status) {
  await db.execute('UPDATE promotions SET status = ? WHERE id = ?', [status, id]);
}

async function deletePromotion(id) {
  await db.execute('DELETE FROM promotions WHERE id = ?', [id]);
}

module.exports = { getPromotions, createPromotion, updatePromotionStatus, deletePromotion };
