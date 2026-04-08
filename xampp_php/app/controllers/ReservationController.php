<?php

class ReservationController
{
    public static function reserve(): void
    {
        require_login();

        $user = current_user();
        $flightId = int_value($_POST['flight_id'] ?? 0);
        $seats = int_value($_POST['seats'] ?? 0);

        if ($flightId < 1 || $seats < 1) {
            flash('error', 'Datos de reserva invalidos.');
            redirect_to('flights');
        }

        $flight = Flight::find($flightId);
        if (!$flight) {
            flash('error', 'Vuelo inexistente.');
            redirect_to('flights');
        }

        if (!Flight::reserveSeats($flightId, $seats)) {
            flash('error', 'No hay asientos suficientes.');
            redirect_to('flights');
        }

        $totalAmount = (float) $flight['price'] * $seats;

        $reservationId = Reservation::create((int) $user['id'], $flightId, $seats, $totalAmount);
        Reservation::confirm($reservationId);

        $mailBody = "Reserva #$reservationId confirmada\n"
            . "Ruta: {$flight['origin']} -> {$flight['destination']}\n"
            . "Asientos: $seats\n"
            . "Total: $" . number_format($totalAmount, 2);
        send_app_mail((string) $user['email'], 'Reserva confirmada', $mailBody);

        flash('ok', 'Reserva realizada y confirmada.');
        redirect_to('reservations');
    }

    public static function cancel(): void
    {
        require_login();

        $user = current_user();
        $reservationId = int_value($_POST['reservation_id'] ?? 0);

        $reservation = Reservation::find($reservationId);
        if (!$reservation) {
            flash('error', 'Reserva no encontrada.');
            redirect_to('reservations');
        }

        $isOwner = (int) $reservation['user_id'] === (int) $user['id'];
        $isAdmin = $user['role'] === 'admin';

        if (!$isOwner && !$isAdmin) {
            flash('error', 'No tenes permisos para cancelar esta reserva.');
            redirect_to('reservations');
        }

        $departure = new DateTime($reservation['departure_time']);
        $now = new DateTime();
        $hours = ($departure->getTimestamp() - $now->getTimestamp()) / 3600;

        if ($hours < 72) {
            flash('error', 'Solo se puede cancelar con 72 horas de anticipacion.');
            redirect_to('reservations');
        }

        if ($reservation['status'] !== 'cancelled') {
            Reservation::cancel($reservationId);
            Flight::returnSeats((int) $reservation['flight_id'], (int) $reservation['seats']);
            send_app_mail((string) $user['email'], 'Reserva cancelada', "Tu reserva #$reservationId fue cancelada correctamente.");
            flash('ok', 'Reserva cancelada correctamente.');
        }

        redirect_to('reservations');
    }

    public static function listPage(): void
    {
        require_login();
        $user = current_user();
        $reservations = Reservation::byUser((int) $user['id']);
        view('reservations', ['reservations' => $reservations]);
    }
}
