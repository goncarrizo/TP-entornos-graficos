const ApiError = require('../utils/ApiError');
const { getNews, createNews, updateNews, deleteNews } = require('../models/newsModel');

async function list(req, res, next) {
  try {
    const data = await getNews();
    res.json(data);
  } catch (error) {
    next(error);
  }
}

async function create(req, res, next) {
  try {
    const { title, content } = req.body;
    if (!title || !content) {
      throw new ApiError(400, 'title y content son obligatorios');
    }
    const id = await createNews({ title, content });
    res.status(201).json({ message: 'Novedad creada', id });
  } catch (error) {
    next(error);
  }
}

async function update(req, res, next) {
  try {
    const { title, content } = req.body;
    await updateNews(req.params.id, { title, content });
    res.json({ message: 'Novedad actualizada' });
  } catch (error) {
    next(error);
  }
}

async function remove(req, res, next) {
  try {
    await deleteNews(req.params.id);
    res.json({ message: 'Novedad eliminada' });
  } catch (error) {
    next(error);
  }
}

module.exports = { list, create, update, remove };
