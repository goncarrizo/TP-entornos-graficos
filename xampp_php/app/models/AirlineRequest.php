<?php

class AirlineRequest
{
    public static function allPending(): array
    {
        $sql = "SELECT ar.*, u.name AS submitted_by_name, reviewer.name AS reviewed_by_name
                FROM airline_requests ar
                JOIN users u ON u.id = ar.submitted_by
                LEFT JOIN users reviewer ON reviewer.id = ar.reviewed_by
                WHERE ar.status = 'pending'
                ORDER BY ar.created_at DESC";

        $stmt = Database::connection()->query($sql);
        return $stmt->fetchAll();
    }

    public static function byUser(int $userId): array
    {
        $sql = "SELECT ar.*, u.name AS submitted_by_name, reviewer.name AS reviewed_by_name
                FROM airline_requests ar
                JOIN users u ON u.id = ar.submitted_by
                LEFT JOIN users reviewer ON reviewer.id = ar.reviewed_by
                WHERE ar.submitted_by = :user_id
                ORDER BY ar.created_at DESC";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $sql = "SELECT ar.*, u.name AS submitted_by_name, reviewer.name AS reviewed_by_name
                FROM airline_requests ar
                JOIN users u ON u.id = ar.submitted_by
                LEFT JOIN users reviewer ON reviewer.id = ar.reviewed_by
                WHERE ar.id = :id
                LIMIT 1";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findByCode(string $code): ?array
    {
        $sql = 'SELECT * FROM airline_requests WHERE code = :code LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['code' => $code]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(string $name, string $code, string $country, int $submittedBy): bool
    {
        $sql = 'INSERT INTO airline_requests (name, code, country, submitted_by) VALUES (:name, :code, :country, :submitted_by)';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute([
            'name' => $name,
            'code' => $code,
            'country' => $country,
            'submitted_by' => $submittedBy,
        ]);
    }

    public static function setStatus(int $id, string $status, int $reviewedBy): bool
    {
        $sql = 'UPDATE airline_requests SET status = :status, reviewed_by = :reviewed_by, reviewed_at = NOW() WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'status' => $status,
            'reviewed_by' => $reviewedBy,
        ]);
    }
}
