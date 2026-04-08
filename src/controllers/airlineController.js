const ApiError = require('../utils/ApiError');
const { getAllAirlines, createAirline, updateAirline, deleteAirline } = require('../models/airlineModel');

async function listAirlines(req, res, next) {
  try {
    const data = await getAllAirlines();
    res.json(data);
  } catch (error) {
    next(error);
  }
}

async function create(req, res, next) {
  try {
    const { name, code, country } = req.body;
    if (!name || !code || !country) {
      throw new ApiError(400, 'name, code y country son obligatorios');
    }
    const id = await createAirline({ name, code, country });
    res.status(201).json({ message: 'Aerolinea creada', id });
  } catch (error) {
    next(error);
  }
}

async function update(req, res, next) {
  try {
    const { id } = req.params;
    const { name, code, country } = req.body;
    await updateAirline(id, { name, code, country });
    res.json({ message: 'Aerolinea actualizada' });
  } catch (error) {
    next(error);
  }
}

async function remove(req, res, next) {
  try {
    const { id } = req.params;
    await deleteAirline(id);
    res.json({ message: 'Aerolinea eliminada' });
  } catch (error) {
    next(error);
  }
}

module.exports = { listAirlines, create, update, remove };
