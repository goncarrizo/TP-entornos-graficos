const {
  getFlights,
  getFlightById,
  createFlight,
  updateFlight,
  deleteFlight,
} = require('../models/flightModel');

async function list(req, res, next) {
  try {
    const { origin, destination, date } = req.query;
    const data = await getFlights({ origin, destination, date });
    res.json(data);
  } catch (error) {
    next(error);
  }
}

async function detail(req, res, next) {
  try {
    const flight = await getFlightById(req.params.id);
    if (!flight) {
      return res.status(404).json({ error: 'Vuelo no encontrado' });
    }
    res.json(flight);
  } catch (error) {
    next(error);
  }
}

async function create(req, res, next) {
  try {
    const id = await createFlight(req.body);
    res.status(201).json({ message: 'Vuelo creado', id });
  } catch (error) {
    next(error);
  }
}

async function update(req, res, next) {
  try {
    await updateFlight(req.params.id, req.body);
    res.json({ message: 'Vuelo actualizado' });
  } catch (error) {
    next(error);
  }
}

async function remove(req, res, next) {
  try {
    await deleteFlight(req.params.id);
    res.json({ message: 'Vuelo eliminado' });
  } catch (error) {
    next(error);
  }
}

module.exports = { list, detail, create, update, remove };
