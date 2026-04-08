<?php

class CeoController
{
    public static function panel(): void
    {
        require_role('ceo');

        $flights = Flight::all();
        $airlines = Airline::all();
        $promotions = Promotion::all();
        $sales = Report::salesByAirline();
        $occupancy = Report::occupancyByFlight();

        view('ceo', compact('flights', 'airlines', 'promotions', 'sales', 'occupancy'));
    }

    public static function createPromotion(): void
    {
        require_role('ceo');

        $airlineId = int_value($_POST['airline_id'] ?? 0);
        $title = clean_text($_POST['title'] ?? '');
        $description = clean_text($_POST['description'] ?? '');
        $discount = (float) ($_POST['discount_percent'] ?? 0);

        if ($airlineId < 1 || $title === '' || $discount <= 0) {
            flash('error', 'Datos invalidos para promocion.');
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
        $airlineId = int_value($_POST['airline_id'] ?? 0);
        $title = clean_text($_POST['title'] ?? '');
        $description = clean_text($_POST['description'] ?? '');
        $discount = (float) ($_POST['discount_percent'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($id < 1 || $airlineId < 1 || $title === '' || $discount <= 0) {
            flash('error', 'Datos invalidos para actualizar promocion.');
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
