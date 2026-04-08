const db = require('../config/db');

async function getNews() {
  const [rows] = await db.execute('SELECT * FROM news ORDER BY created_at DESC');
  return rows;
}

async function createNews({ title, content }) {
  const [result] = await db.execute('INSERT INTO news (title, content) VALUES (?, ?)', [title, content]);
  return result.insertId;
}

async function updateNews(id, { title, content }) {
  await db.execute('UPDATE news SET title = ?, content = ? WHERE id = ?', [title, content, id]);
}

async function deleteNews(id) {
  await db.execute('DELETE FROM news WHERE id = ?', [id]);
}

module.exports = { getNews, createNews, updateNews, deleteNews };
