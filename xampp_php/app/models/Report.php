<?php

class Report
{
    public static function salesByAirline(?int $airlineId = null): array
    {
        $sql = "SELECT a.name AS airline, COALESCE(SUM(r.total_amount), 0) AS total_sales
                FROM airlines a
                LEFT JOIN flights f ON f.airline_id = a.id
                LEFT JOIN reservations r ON r.flight_id = f.id AND r.status = 'confirmed'";

        $params = [];
        if ($airlineId !== null && $airlineId > 0) {
            $sql .= ' WHERE a.id = :airline_id';
            $params['airline_id'] = $airlineId;
        }

        $sql .= ' GROUP BY a.id ORDER BY total_sales DESC';

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function occupancyByFlight(?int $airlineId = null): array
    {
        $sql = "SELECT id, origin, destination, total_seats,
                       (total_seats - available_seats) AS occupied_seats,
                       ROUND(((total_seats - available_seats) / total_seats) * 100, 2) AS occupancy_percent
                FROM flights";

        $params = [];
        if ($airlineId !== null && $airlineId > 0) {
            $sql .= ' WHERE airline_id = :airline_id';
            $params['airline_id'] = $airlineId;
        }

        $sql .= ' ORDER BY occupancy_percent DESC';

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function general(): array
    {
        return [
            'users' => User::countAll(),
            'flights' => Flight::countAll(),
            'reservations' => Reservation::countAll(),
        ];
    }
}
