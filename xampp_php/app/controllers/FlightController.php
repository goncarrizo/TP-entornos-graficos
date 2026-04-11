<?php

class FlightController
{
    public static function listPage(): void
    {
        $origin = clean_text($_GET['origin'] ?? '');
        $destination = clean_text($_GET['destination'] ?? '');
        $date = clean_text($_GET['date'] ?? '');
        $airlineId = int_value($_GET['airline_id'] ?? 0);
        $minPrice = $_GET['min_price'] ?? '';
        $maxPrice = $_GET['max_price'] ?? '';
        $minSeats = int_value($_GET['min_seats'] ?? 0);
        $maxDuration = int_value($_GET['max_duration'] ?? 0);
        $sort = clean_text($_GET['sort'] ?? 'departure_asc');
        $page = max(1, (int) ($_GET['p'] ?? 1));
        $perPage = 6;

        $minPriceValue = $minPrice !== '' ? max(0, (float) $minPrice) : null;
        $maxPriceValue = $maxPrice !== '' ? max(0, (float) $maxPrice) : null;
        $minSeatsValue = $minSeats > 0 ? $minSeats : null;
        $maxDurationValue = $maxDuration > 0 ? $maxDuration : null;
        $airlineIdValue = $airlineId > 0 ? $airlineId : null;

        $total = Flight::countFiltered($origin ?: null, $destination ?: null, $date ?: null, $airlineIdValue, $minPriceValue, $maxPriceValue, $minSeatsValue, $maxDurationValue);
        $pager = paginate($total, $perPage, $page);

        $flights = Flight::paginated($pager['limit'], $pager['offset'], $origin ?: null, $destination ?: null, $date ?: null, $airlineIdValue, $minPriceValue, $maxPriceValue, $minSeatsValue, $maxDurationValue, $sort);
        $airlines = Airline::all();

        $favoriteIds = [];
        if (is_logged_in()) {
            $favoriteIds = Favorite::idsByUser((int) current_user()['id']);
        }

        view('flights', [
            'flights' => $flights,
            'airlines' => $airlines,
            'origin' => $origin,
            'destination' => $destination,
            'date' => $date,
            'airline_id' => $airlineId,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'min_seats' => $minSeats,
            'max_duration' => $maxDuration,
            'sort' => $sort,
            'favorite_ids' => $favoriteIds,
            'pager' => $pager,
        ]);
    }

    public static function toggleFavorite(): void
    {
        require_login();

        $userId = (int) current_user()['id'];
        $flightId = int_value($_POST['flight_id'] ?? 0);

        if ($flightId < 1) {
            flash('error', 'Vuelo invalido para favorito.');
            redirect_to('flights');
        }

        $added = Favorite::toggle($userId, $flightId);
        flash('ok', $added ? 'Vuelo agregado a favoritos.' : 'Vuelo eliminado de favoritos.');
        redirect_to('flights');
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
