<?php

class FlightRequest
{
    public static function allPending(): array
    {
        $sql = "SELECT fr.*, a.name AS airline_name, u.name AS submitted_by_name, reviewer.name AS reviewed_by_name
                FROM flight_requests fr
                JOIN users u ON u.id = fr.submitted_by
                LEFT JOIN users reviewer ON reviewer.id = fr.reviewed_by
                JOIN airlines a ON a.id = fr.airline_id
                WHERE fr.status = 'pending'
                ORDER BY fr.created_at DESC";

        $stmt = Database::connection()->query($sql);
        return $stmt->fetchAll();
    }

    public static function byUser(int $userId): array
    {
        $sql = "SELECT fr.*, a.name AS airline_name, u.name AS submitted_by_name, reviewer.name AS reviewed_by_name
                FROM flight_requests fr
                JOIN users u ON u.id = fr.submitted_by
                LEFT JOIN users reviewer ON reviewer.id = fr.reviewed_by
                JOIN airlines a ON a.id = fr.airline_id
                WHERE fr.submitted_by = :user_id
                ORDER BY fr.created_at DESC";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $sql = "SELECT fr.*, a.name AS airline_name, u.name AS submitted_by_name, reviewer.name AS reviewed_by_name
                FROM flight_requests fr
                JOIN users u ON u.id = fr.submitted_by
                LEFT JOIN users reviewer ON reviewer.id = fr.reviewed_by
                JOIN airlines a ON a.id = fr.airline_id
                WHERE fr.id = :id
                LIMIT 1";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function existsDuplicate(array $data): bool
    {
        $sql = 'SELECT 1 FROM flight_requests WHERE airline_id = :airline_id AND origin = :origin AND destination = :destination AND departure_time = :departure_time AND arrival_time = :arrival_time AND status = \'pending\' LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute([
            'airline_id' => (int) $data['airline_id'],
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
        ]);
        return (bool) $stmt->fetchColumn();
    }

    public static function create(array $data): bool
    {
        $sql = 'INSERT INTO flight_requests (airline_id, origin, destination, departure_time, arrival_time, price, total_seats, submitted_by) VALUES (:airline_id, :origin, :destination, :departure_time, :arrival_time, :price, :total_seats, :submitted_by)';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'airline_id' => (int) $data['airline_id'],
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'departure_time' => $data['departure_time'],
            'arrival_time' => $data['arrival_time'],
            'price' => (float) $data['price'],
            'total_seats' => (int) $data['total_seats'],
            'submitted_by' => (int) $data['submitted_by'],
        ]);
    }

    public static function setStatus(int $id, string $status, int $reviewedBy): bool
    {
        $sql = 'UPDATE flight_requests SET status = :status, reviewed_by = :reviewed_by, reviewed_at = NOW() WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'status' => $status,
            'reviewed_by' => $reviewedBy,
        ]);
    }
}
