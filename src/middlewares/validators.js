const { body } = require('express-validator');

const registerValidator = [
  body('name').trim().notEmpty().withMessage('El nombre es obligatorio'),
  body('email').isEmail().withMessage('Email invalido'),
  body('password').isLength({ min: 6 }).withMessage('La clave debe tener al menos 6 caracteres'),
];

const loginValidator = [
  body('email').isEmail().withMessage('Email invalido'),
  body('password').notEmpty().withMessage('La clave es obligatoria'),
];

const flightValidator = [
  body('airline_id').isInt({ min: 1 }).withMessage('airline_id invalido'),
  body('origin').trim().notEmpty().withMessage('Origen obligatorio'),
  body('destination').trim().notEmpty().withMessage('Destino obligatorio'),
  body('departure_time').notEmpty().withMessage('Fecha y hora de salida obligatoria'),
  body('arrival_time').notEmpty().withMessage('Fecha y hora de llegada obligatoria'),
  body('price').isFloat({ min: 0 }).withMessage('Precio invalido'),
  body('total_seats').isInt({ min: 1 }).withMessage('Cantidad de asientos invalida'),
];

const reservationValidator = [
  body('flight_id').isInt({ min: 1 }).withMessage('flight_id invalido'),
  body('seats').isInt({ min: 1 }).withMessage('Cantidad de asientos invalida'),
];

module.exports = {
  registerValidator,
  loginValidator,
  flightValidator,
  reservationValidator,
};
