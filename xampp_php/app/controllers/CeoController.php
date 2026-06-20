<?php

class CeoController
{
    public static function exportSalesCsv(): void
    {
        require_role('ceo');

        $user = current_user();
        $airlineId = (int) ($user['airline_id'] ?? 0);
        if ($airlineId < 1) {
            flash('error', 'Tu cuenta CEO no tiene una aerolinea asignada.');
            redirect_to('ceo');
        }

        $rows = Report::salesByAirline($airlineId);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="reporte_ventas_ceo.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['Aerolinea', 'Ventas confirmadas']);
        foreach ($rows as $row) {
            fputcsv($out, [$row['airline'], (float) $row['total_sales']]);
        }
        fclose($out);
        exit;
    }

    public static function exportOccupancyCsv(): void
    {
        require_role('ceo');

        $user = current_user();
        $airlineId = (int) ($user['airline_id'] ?? 0);
        if ($airlineId < 1) {
            flash('error', 'Tu cuenta CEO no tiene una aerolinea asignada.');
            redirect_to('ceo');
        }

        $rows = Report::occupancyByFlight($airlineId);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="reporte_ocupacion_ceo.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['Vuelo ID', 'Origen', 'Destino', 'Asientos totales', 'Asientos ocupados', 'Ocupacion %']);
        foreach ($rows as $row) {
            fputcsv($out, [
                (int) $row['id'],
                $row['origin'],
                $row['destination'],
                (int) $row['total_seats'],
                (int) $row['occupied_seats'],
                (float) $row['occupancy_percent'],
            ]);
        }
        fclose($out);
        exit;
    }

    public static function panel(): void
    {
        require_role('ceo');

        $user = current_user();
        $airlineId = (int) ($user['airline_id'] ?? 0);
        if ($airlineId < 1) {
            flash('error', 'Tu cuenta CEO no tiene una aerolinea asignada. Contacta al admin.');
            redirect_to('home');
        }

        $airline = Airline::findById($airlineId);
        if (!$airline) {
            flash('error', 'Aerolinea asignada no encontrada. Contacta al admin.');
            redirect_to('home');
        }

        $flights = Flight::all(null, null, null, $airlineId);
        $airlines = [$airline];
        $promotions = Promotion::allByAirline($airlineId);
        $sales = Report::salesByAirline($airlineId);
        $occupancy = Report::occupancyByFlight($airlineId);
        $pendingAirlineRequests = AirlineRequest::byUser((int) $user['id']);
        $pendingFlightRequests = FlightRequest::byUser((int) $user['id']);
        $pendingReservations = Reservation::allPendingByAirline($airlineId);

        view('ceo', compact('flights', 'airlines', 'promotions', 'sales', 'occupancy', 'pendingAirlineRequests', 'pendingFlightRequests', 'pendingReservations'));
    }

    public static function approveReservation(): void
    {
        require_role('ceo');

        $user = current_user();
        $airlineId = (int) ($user['airline_id'] ?? 0);
        $id = int_value($_POST['reservation_id'] ?? 0);
        $reservation = Reservation::find($id);

        if (!$reservation || $reservation['status'] !== 'pending' || (int) $reservation['airline_id'] !== $airlineId) {
            flash('error', 'Reserva no encontrada, no corresponde a tu aerolinea o ya fue procesada.');
            redirect_to('ceo');
        }

        if (Reservation::confirm($id, (int) $user['id'])) {
            flash('ok', 'Reserva aprobada y confirmada.');
            send_app_mail((string) $reservation['user_email'], 'Reserva aprobada', "Tu reserva #$id ha sido aprobada y confirmada.");
        } else {
            flash('error', 'No se pudo aprobar la reserva.');
        }

        redirect_to('ceo');
    }

    public static function denyReservation(): void
    {
        require_role('ceo');

        $user = current_user();
        $airlineId = (int) ($user['airline_id'] ?? 0);
        $id = int_value($_POST['reservation_id'] ?? 0);
        $reservation = Reservation::find($id);

        if (!$reservation || $reservation['status'] !== 'pending' || (int) $reservation['airline_id'] !== $airlineId) {
            flash('error', 'Reserva no encontrada, no corresponde a tu aerolinea o ya fue procesada.');
            redirect_to('ceo');
        }

        if (Reservation::deny($id, (int) $user['id'])) {
            Flight::returnSeats((int) $reservation['flight_id'], (int) $reservation['seats']);
            flash('ok', 'Reserva denegada. Los asientos fueron liberados.');
            send_app_mail((string) $reservation['user_email'], 'Reserva denegada', "Tu reserva #$id ha sido denegada por el CEO.");
        } else {
            flash('error', 'No se pudo denegar la reserva.');
        }

        redirect_to('ceo');
    }

    public static function createAirlineRequest(): void
    {
        require_role('ceo');

        $name = clean_text($_POST['name'] ?? '');
        $code = strtoupper(clean_text($_POST['code'] ?? ''));
        $country = clean_text($_POST['country'] ?? '');
        $userId = (int) current_user()['id'];

        if ($name === '' || $code === '' || $country === '') {
            flash('error', 'Completa todos los campos de la propuesta de aerolinea.');
            redirect_to('ceo');
        }

        if (!preg_match('/^[A-Z0-9]{2,10}$/', $code)) {
            flash('error', 'El codigo de aerolinea debe tener entre 2 y 10 caracteres alfanumericos.');
            redirect_to('ceo');
        }

        if (Airline::findByCode($code) || AirlineRequest::findByCode($code)) {
            flash('error', 'Ya existe una aerolinea o una propuesta con ese codigo.');
            redirect_to('ceo');
        }

        AirlineRequest::create($name, $code, $country, $userId);
        flash('ok', 'Tu propuesta de aerolinea fue enviada para revision admin.');
        redirect_to('ceo');
    }

    public static function createPromotion(): void
    {
        require_role('ceo');
        $user = current_user();
        $userAirlineId = (int) ($user['airline_id'] ?? 0);
        $airlineId = int_value($_POST['airline_id'] ?? 0);
        $title = clean_text($_POST['title'] ?? '');
        $description = clean_text($_POST['description'] ?? '');
        $discount = (float) ($_POST['discount_percent'] ?? 0);

        if ($airlineId < 1 || $title === '' || $discount <= 0) {
            flash('error', 'Datos invalidos para promocion.');
            redirect_to('ceo');
        }

        // Ensure CEO can only create promotions for their assigned airline
        if ($userAirlineId < 1 || $airlineId !== $userAirlineId) {
            flash('error', 'No autorizado para crear promociones para esa aerolinea.');
            redirect_to('ceo');
        }

        Promotion::create($airlineId, $title, $description, $discount);
        flash('ok', 'Promocion creada y enviada para aprobacion.');
        redirect_to('ceo');
    }

    public static function updatePromotion(): void
    {
        require_role('ceo');

        $id = int_value($_POST['promotion_id'] ?? 0);
        $user = current_user();
        $userAirlineId = (int) ($user['airline_id'] ?? 0);
        $airlineId = int_value($_POST['airline_id'] ?? 0);
        $title = clean_text($_POST['title'] ?? '');
        $description = clean_text($_POST['description'] ?? '');
        $discount = (float) ($_POST['discount_percent'] ?? 0);
        // CEOs are not allowed to activate promotions directly; only admins can approve/activate.
        $isActive = 0;

        if ($id < 1 || $airlineId < 1 || $title === '' || $discount <= 0) {
            flash('error', 'Datos invalidos para actualizar promocion.');
            redirect_to('ceo');
        }
        // Ensure CEO can only update promotions for their assigned airline
        if ($userAirlineId < 1 || $airlineId !== $userAirlineId) {
            flash('error', 'No autorizado para editar promociones de esa aerolinea.');
            redirect_to('ceo');
        }

        Promotion::update($id, $airlineId, $title, $description, $discount, $isActive);
        flash('ok', 'Promocion actualizada.');
        redirect_to('ceo');
    }

    public static function deletePromotion(): void
    {
        require_role('ceo');
        $id = int_value($_POST['promotion_id'] ?? 0);

        if ($id > 0) {
            Promotion::delete($id);
            flash('ok', 'Promocion eliminada.');
        }

        redirect_to('ceo');
    }
}
