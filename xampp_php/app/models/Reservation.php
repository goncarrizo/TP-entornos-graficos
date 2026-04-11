<?php

class Reservation
{
    public static function create(int $userId, int $flightId, int $seats, float $totalAmount, ?int $changedByUserId = null): int
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

        $reservationId = (int) Database::connection()->lastInsertId();
        self::logStatusChange($reservationId, null, 'pending', $changedByUserId, 'Reserva creada');

        return $reservationId;
    }

    public static function confirm(int $id, ?int $changedByUserId = null): bool
    {
        $current = self::find($id);
        $fromStatus = $current['status'] ?? null;

        $stmt = Database::connection()->prepare('UPDATE reservations SET status = :status WHERE id = :id');
        $ok = $stmt->execute(['id' => $id, 'status' => 'confirmed']);

        if ($ok && $fromStatus !== 'confirmed') {
            self::logStatusChange($id, $fromStatus, 'confirmed', $changedByUserId, 'Reserva confirmada');
        }

        return $ok;
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

    public static function cancel(int $id, ?int $changedByUserId = null): bool
    {
        $current = self::find($id);
        $fromStatus = $current['status'] ?? null;

        $stmt = Database::connection()->prepare('UPDATE reservations SET status = :status WHERE id = :id');
        $ok = $stmt->execute(['id' => $id, 'status' => 'cancelled']);

        if ($ok && $fromStatus !== 'cancelled') {
            self::logStatusChange($id, $fromStatus, 'cancelled', $changedByUserId, 'Reserva cancelada');
        }

        return $ok;
    }

    public static function countAll(): int
    {
        $stmt = Database::connection()->query('SELECT COUNT(*) AS c FROM reservations');
        $row = $stmt->fetch();
        return (int) $row['c'];
    }

    public static function historyByUser(int $userId): array
    {
        $sql = "SELECT rsh.*, r.user_id, f.origin, f.destination, u.name AS changed_by_name
                FROM reservation_status_history rsh
                JOIN reservations r ON r.id = rsh.reservation_id
                JOIN flights f ON f.id = r.flight_id
                LEFT JOIN users u ON u.id = rsh.changed_by_user_id
                WHERE r.user_id = :user_id
                ORDER BY rsh.changed_at DESC";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll();
    }

    private static function logStatusChange(int $reservationId, ?string $fromStatus, string $toStatus, ?int $changedByUserId, ?string $note = null): bool
    {
        $sql = 'INSERT INTO reservation_status_history (reservation_id, from_status, to_status, changed_by_user_id, note) VALUES (:reservation_id, :from_status, :to_status, :changed_by_user_id, :note)';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'reservation_id' => $reservationId,
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'changed_by_user_id' => $changedByUserId,
            'note' => $note,
        ]);
    }
}
