const { salesByAirline, occupancyByFlight, generalCounts } = require('../models/reportModel');

async function getSales(req, res, next) {
  try {
    const data = await salesByAirline();
    res.json(data);
  } catch (error) {
    next(error);
  }
}

async function getOccupancy(req, res, next) {
  try {
    const data = await occupancyByFlight();
    res.json(data);
  } catch (error) {
    next(error);
  }
}

async function getGeneral(req, res, next) {
  try {
    const data = await generalCounts();
    res.json(data);
  } catch (error) {
    next(error);
  }
}

module.exports = { getSales, getOccupancy, getGeneral };
