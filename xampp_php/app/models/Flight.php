<?php

class Flight
{
    public static function countFiltered(?string $origin = null, ?string $destination = null, ?string $date = null): int
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

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return (int) $row['c'];
    }

    public static function all(?string $origin = null, ?string $destination = null, ?string $date = null): array
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

        $sql .= ' ORDER BY f.departure_time ASC';

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function paginated(int $limit, int $offset, ?string $origin = null, ?string $destination = null, ?string $date = null): array
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

        $sql .= ' ORDER BY f.departure_time ASC LIMIT :limit OFFSET :offset';

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
}
