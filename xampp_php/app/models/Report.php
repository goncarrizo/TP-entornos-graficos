<?php

class Report
{
    public static function salesByAirline(): array
    {
        $sql = "SELECT a.name AS airline, COALESCE(SUM(r.total_amount), 0) AS total_sales
                FROM airlines a
                LEFT JOIN flights f ON f.airline_id = a.id
                LEFT JOIN reservations r ON r.flight_id = f.id AND r.status = 'confirmed'
                GROUP BY a.id
                ORDER BY total_sales DESC";
        $stmt = Database::connection()->query($sql);
        return $stmt->fetchAll();
    }

    public static function occupancyByFlight(): array
    {
        $sql = "SELECT id, origin, destination, total_seats,
                       (total_seats - available_seats) AS occupied_seats,
                       ROUND(((total_seats - available_seats) / total_seats) * 100, 2) AS occupancy_percent
                FROM flights
                ORDER BY occupancy_percent DESC";
        $stmt = Database::connection()->query($sql);
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
