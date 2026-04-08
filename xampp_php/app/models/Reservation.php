<?php

class Reservation
{
    public static function create(int $userId, int $flightId, int $seats, float $totalAmount): int
    {
        $sql = 'INSERT INTO reservations (user_id, flight_id, seats, total_amount, status) VALUES (:user_id, :flight_id, :seats, :total_amount, :status)';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'flight_id' => $flightId,
            'seats' => $seats,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        return (int) Database::connection()->lastInsertId();
    }

    public static function confirm(int $id): bool
    {
        $stmt = Database::connection()->prepare('UPDATE reservations SET status = :status WHERE id = :id');
        return $stmt->execute(['id' => $id, 'status' => 'confirmed']);
    }

    public static function find(int $id): ?array
    {
        $sql = 'SELECT r.*, f.departure_time FROM reservations r JOIN flights f ON f.id = r.flight_id WHERE r.id = :id LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function byUser(int $userId): array
    {
        $sql = "SELECT r.*, f.origin, f.destination, f.departure_time, a.name AS airline_name
                FROM reservations r
                JOIN flights f ON f.id = r.flight_id
                JOIN airlines a ON a.id = f.airline_id
                WHERE r.user_id = :user_id
                ORDER BY r.created_at DESC";
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function cancel(int $id): bool
    {
        $stmt = Database::connection()->prepare('UPDATE reservations SET status = :status WHERE id = :id');
        return $stmt->execute(['id' => $id, 'status' => 'cancelled']);
    }

    public static function countAll(): int
    {
        $stmt = Database::connection()->query('SELECT COUNT(*) AS c FROM reservations');
        $row = $stmt->fetch();
        return (int) $row['c'];
    }
}
