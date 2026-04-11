<?php

class Flight
{
    public static function countFiltered(?string $origin = null, ?string $destination = null, ?string $date = null, ?int $airlineId = null, ?float $minPrice = null, ?float $maxPrice = null, ?int $minSeats = null, ?int $maxDurationMinutes = null): int
    {
        $sql = 'SELECT COUNT(*) AS c FROM flights f WHERE 1 = 1';
        $params = [];

        if ($origin) {
            $sql .= ' AND f.origin = :origin';
            $params['origin'] = $origin;
        }

        if ($destination) {
            $sql .= ' AND f.destination = :destination';
            $params['destination'] = $destination;
        }

        if ($date) {
            $sql .= ' AND DATE(f.departure_time) = :date';
            $params['date'] = $date;
        }

        if ($airlineId && $airlineId > 0) {
            $sql .= ' AND f.airline_id = :airline_id';
            $params['airline_id'] = $airlineId;
        }

        if ($minPrice !== null && $minPrice >= 0) {
            $sql .= ' AND f.price >= :min_price';
            $params['min_price'] = $minPrice;
        }

        if ($maxPrice !== null && $maxPrice >= 0) {
            $sql .= ' AND f.price <= :max_price';
            $params['max_price'] = $maxPrice;
        }

        if ($minSeats !== null && $minSeats > 0) {
            $sql .= ' AND f.available_seats >= :min_seats';
            $params['min_seats'] = $minSeats;
        }

        if ($maxDurationMinutes !== null && $maxDurationMinutes > 0) {
            $sql .= ' AND TIMESTAMPDIFF(MINUTE, f.departure_time, f.arrival_time) <= :max_duration';
            $params['max_duration'] = $maxDurationMinutes;
        }

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return (int) $row['c'];
    }

    public static function all(?string $origin = null, ?string $destination = null, ?string $date = null, ?int $airlineId = null, ?float $minPrice = null, ?float $maxPrice = null, ?int $minSeats = null, ?int $maxDurationMinutes = null, string $sort = 'departure_asc'): array
    {
        $sql = "SELECT f.*, a.name AS airline_name, p.title AS promo_title, p.discount_percent
                FROM flights f
                JOIN airlines a ON a.id = f.airline_id
                LEFT JOIN promotions p ON p.airline_id = f.airline_id AND p.status = 'approved' AND p.is_active = 1
                WHERE 1 = 1";

        $params = [];

        if ($origin) {
            $sql .= ' AND f.origin = :origin';
            $params['origin'] = $origin;
        }

        if ($destination) {
            $sql .= ' AND f.destination = :destination';
            $params['destination'] = $destination;
        }

        if ($date) {
            $sql .= ' AND DATE(f.departure_time) = :date';
            $params['date'] = $date;
        }

        if ($airlineId && $airlineId > 0) {
            $sql .= ' AND f.airline_id = :airline_id';
            $params['airline_id'] = $airlineId;
        }

        if ($minPrice !== null && $minPrice >= 0) {
            $sql .= ' AND f.price >= :min_price';
            $params['min_price'] = $minPrice;
        }

        if ($maxPrice !== null && $maxPrice >= 0) {
            $sql .= ' AND f.price <= :max_price';
            $params['max_price'] = $maxPrice;
        }

        if ($minSeats !== null && $minSeats > 0) {
            $sql .= ' AND f.available_seats >= :min_seats';
            $params['min_seats'] = $minSeats;
        }

        if ($maxDurationMinutes !== null && $maxDurationMinutes > 0) {
            $sql .= ' AND TIMESTAMPDIFF(MINUTE, f.departure_time, f.arrival_time) <= :max_duration';
            $params['max_duration'] = $maxDurationMinutes;
        }

        $sql .= ' ' . self::buildOrderBy($sort);

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function paginated(int $limit, int $offset, ?string $origin = null, ?string $destination = null, ?string $date = null, ?int $airlineId = null, ?float $minPrice = null, ?float $maxPrice = null, ?int $minSeats = null, ?int $maxDurationMinutes = null, string $sort = 'departure_asc'): array
    {
        $sql = "SELECT f.*, a.name AS airline_name, p.title AS promo_title, p.discount_percent
                FROM flights f
                JOIN airlines a ON a.id = f.airline_id
                LEFT JOIN promotions p ON p.airline_id = f.airline_id AND p.status = 'approved' AND p.is_active = 1
                WHERE 1 = 1";

        $params = [];

        if ($origin) {
            $sql .= ' AND f.origin = :origin';
            $params['origin'] = $origin;
        }

        if ($destination) {
            $sql .= ' AND f.destination = :destination';
            $params['destination'] = $destination;
        }

        if ($date) {
            $sql .= ' AND DATE(f.departure_time) = :date';
            $params['date'] = $date;
        }

        if ($airlineId && $airlineId > 0) {
            $sql .= ' AND f.airline_id = :airline_id';
            $params['airline_id'] = $airlineId;
        }

        if ($minPrice !== null && $minPrice >= 0) {
            $sql .= ' AND f.price >= :min_price';
            $params['min_price'] = $minPrice;
        }

        if ($maxPrice !== null && $maxPrice >= 0) {
            $sql .= ' AND f.price <= :max_price';
            $params['max_price'] = $maxPrice;
        }

        if ($minSeats !== null && $minSeats > 0) {
            $sql .= ' AND f.available_seats >= :min_seats';
            $params['min_seats'] = $minSeats;
        }

        if ($maxDurationMinutes !== null && $maxDurationMinutes > 0) {
            $sql .= ' AND TIMESTAMPDIFF(MINUTE, f.departure_time, f.arrival_time) <= :max_duration';
            $params['max_duration'] = $maxDurationMinutes;
        }

        $sql .= ' ' . self::buildOrderBy($sort) . ' LIMIT :limit OFFSET :offset';

        $stmt = Database::connection()->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $sql = 'SELECT * FROM flights WHERE id = :id LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): bool
    {
        $sql = 'INSERT INTO flights (airline_id, origin, destination, departure_time, arrival_time, price, total_seats, available_seats)
                VALUES (:airline_id, :origin, :destination, :departure_time, :arrival_time, :price, :total_seats, :available_seats)';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'airline_id' => (int) $data['airline_id'],
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
            'price' => (float) $data['price'],
            'total_seats' => (int) $data['total_seats'],
            'available_seats' => (int) $data['total_seats'],
        ]);
    }

    public static function update(int $id, array $data): bool
    {
        $sql = 'UPDATE flights SET airline_id = :airline_id, origin = :origin, destination = :destination, departure_time = :departure_time, arrival_time = :arrival_time, price = :price, total_seats = :total_seats WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'airline_id' => (int) $data['airline_id'],
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
            'price' => (float) $data['price'],
            'total_seats' => (int) $data['total_seats'],
        ]);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::connection()->prepare('DELETE FROM flights WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public static function reserveSeats(int $flightId, int $seats): bool
    {
        $sql = 'UPDATE flights SET available_seats = available_seats - :seats WHERE id = :id AND available_seats >= :seats';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $flightId, 'seats' => $seats]);
        return $stmt->rowCount() > 0;
    }

    public static function returnSeats(int $flightId, int $seats): bool
    {
        $sql = 'UPDATE flights SET available_seats = available_seats + :seats WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute(['id' => $flightId, 'seats' => $seats]);
    }

    public static function countAll(): int
    {
        $stmt = Database::connection()->query('SELECT COUNT(*) AS c FROM flights');
        $row = $stmt->fetch();
        return (int) $row['c'];
    }

    private static function buildOrderBy(string $sort): string
    {
        switch ($sort) {
            case 'price_asc':
                return 'ORDER BY f.price ASC';
            case 'price_desc':
                return 'ORDER BY f.price DESC';
            case 'seats_desc':
                return 'ORDER BY f.available_seats DESC, f.departure_time ASC';
            case 'duration_asc':
                return 'ORDER BY TIMESTAMPDIFF(MINUTE, f.departure_time, f.arrival_time) ASC';
            case 'departure_desc':
                return 'ORDER BY f.departure_time DESC';
            case 'departure_asc':
            default:
                return 'ORDER BY f.departure_time ASC';
        }
    }
}
