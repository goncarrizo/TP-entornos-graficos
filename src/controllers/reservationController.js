const ApiError = require('../utils/ApiError');
const { getFlightById, reduceSeats, addSeats } = require('../models/flightModel');
const {
  createReservation,
  confirmReservation,
  findReservationById,
  getUserReservations,
  cancelReservation,
} = require('../models/reservationModel');

async function create(req, res, next) {
  try {
    const { flight_id: flightId, seats } = req.body;

    const flight = await getFlightById(flightId);
    if (!flight) {
      throw new ApiError(404, 'Vuelo no encontrado');
    }

    const enoughSeats = await reduceSeats(flightId, seats);
    if (!enoughSeats) {
      throw new ApiError(400, 'No hay asientos suficientes');
    }

    const totalAmount = Number(flight.price) * Number(seats);

    // Estado inicial pendiente y luego confirmada (simulado en el mismo flujo).
    const reservationId = await createReservation({
      userId: req.user.id,
      flightId,
      seats,
      totalAmount,
      status: 'pending',
    });

    await confirmReservation(reservationId);

    res.status(201).json({
      message: 'Reserva creada y confirmada',
      reservationId,
      totalAmount,
    });
  } catch (error) {
    next(error);
  }
}

async function listMine(req, res, next) {
  try {
    const data = await getUserReservations(req.user.id);
    res.json(data);
  } catch (error) {
    next(error);
  }
}

async function cancel(req, res, next) {
  try {
    const reservation = await findReservationById(req.params.id);
    if (!reservation) {
      throw new ApiError(404, 'Reserva no encontrada');
    }

    if (reservation.user_id !== req.user.id && req.user.role !== 'admin') {
      throw new ApiError(403, 'No tenes permiso para cancelar esta reserva');
    }

    if (reservation.status === 'cancelled') {
      throw new ApiError(400, 'La reserva ya estaba cancelada');
    }

    const departure = new Date(reservation.departure_time);
    const now = new Date();
    const diffMs = departure - now;
    const diffHours = diffMs / (1000 * 60 * 60);

    if (diffHours < 72) {
      throw new ApiError(400, 'Solo se puede cancelar con al menos 72 horas de anticipacion');
    }

    await cancelReservation(reservation.id);
    await addSeats(reservation.flight_id, reservation.seats);

    res.json({ message: 'Reserva cancelada correctamente' });
  } catch (error) {
    next(error);
  }
}

module.exports = { create, listMine, cancel };
