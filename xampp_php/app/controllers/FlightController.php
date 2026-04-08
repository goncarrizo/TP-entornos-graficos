<?php

class FlightController
{
    public static function listPage(): void
    {
        $origin = clean_text($_GET['origin'] ?? '');
        $destination = clean_text($_GET['destination'] ?? '');
        $date = clean_text($_GET['date'] ?? '');
        $page = max(1, (int) ($_GET['p'] ?? 1));
        $perPage = 6;

        $total = Flight::countFiltered($origin ?: null, $destination ?: null, $date ?: null);
        $pager = paginate($total, $perPage, $page);

        $flights = Flight::paginated($pager['limit'], $pager['offset'], $origin ?: null, $destination ?: null, $date ?: null);
        $airlines = Airline::all();

        view('flights', [
            'flights' => $flights,
            'airlines' => $airlines,
            'origin' => $origin,
            'destination' => $destination,
            'date' => $date,
            'pager' => $pager,
        ]);
    }

    public static function create(): void
    {
        require_role('ceo');

        $data = [
            'airline_id' => int_value($_POST['airline_id'] ?? 0),
            'origin' => clean_text($_POST['origin'] ?? ''),
            'destination' => clean_text($_POST['destination'] ?? ''),
            'departure_time' => clean_text($_POST['departure_time'] ?? ''),
            'arrival_time' => clean_text($_POST['arrival_time'] ?? ''),
            'price' => (float) ($_POST['price'] ?? 0),
            'total_seats' => int_value($_POST['total_seats'] ?? 0),
        ];

        if ($data['airline_id'] < 1 || $data['origin'] === '' || $data['destination'] === '' || $data['total_seats'] < 1) {
            flash('error', 'Datos invalidos para crear vuelo.');
            redirect_to('ceo');
        }

        Flight::create($data);
        flash('ok', 'Vuelo creado correctamente.');
        redirect_to('ceo');
    }

    public static function update(): void
    {
        require_role('ceo');

        $id = int_value($_POST['flight_id'] ?? 0);
        $data = [
            'airline_id' => int_value($_POST['airline_id'] ?? 0),
            'origin' => clean_text($_POST['origin'] ?? ''),
            'destination' => clean_text($_POST['destination'] ?? ''),
            'departure_time' => clean_text($_POST['departure_time'] ?? ''),
            'arrival_time' => clean_text($_POST['arrival_time'] ?? ''),
            'price' => (float) ($_POST['price'] ?? 0),
            'total_seats' => int_value($_POST['total_seats'] ?? 0),
        ];

        if ($id < 1 || $data['airline_id'] < 1 || $data['origin'] === '' || $data['destination'] === '' || $data['total_seats'] < 1) {
            flash('error', 'Datos invalidos para actualizar vuelo.');
            redirect_to('ceo');
        }

        Flight::update($id, $data);
        flash('ok', 'Vuelo actualizado correctamente.');
        redirect_to('ceo');
    }

    public static function delete(): void
    {
        require_role('ceo');
        $id = int_value($_POST['flight_id'] ?? 0);

        if ($id > 0) {
            Flight::delete($id);
            flash('ok', 'Vuelo eliminado.');
        }

        redirect_to('ceo');
    }
}
