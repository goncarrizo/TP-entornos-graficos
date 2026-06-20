<?php

class Promotion
{
    public static function all(): array
    {
        $sql = 'SELECT p.*, a.name AS airline_name FROM promotions p JOIN airlines a ON a.id = p.airline_id ORDER BY p.created_at DESC';
        $stmt = Database::connection()->query($sql);
        return $stmt->fetchAll();
    }

    public static function create(int $airlineId, string $title, string $description, float $discount): bool
    {
        $sql = 'INSERT INTO promotions (airline_id, title, description, discount_percent, status, is_active) VALUES (:airline_id, :title, :description, :discount_percent, :status, :is_active)';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'airline_id' => $airlineId,
            'title' => $title,
            'description' => $description,
            'discount_percent' => $discount,
            'status' => 'pending',
            'is_active' => 0,
        ]);
    }

    public static function allByAirline(int $airlineId): array
    {
        $sql = 'SELECT p.*, a.name AS airline_name FROM promotions p JOIN airlines a ON a.id = p.airline_id WHERE p.airline_id = :airline_id ORDER BY p.created_at DESC';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['airline_id' => $airlineId]);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $sql = 'SELECT * FROM promotions WHERE id = :id LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function update(int $id, int $airlineId, string $title, string $description, float $discount, int $isActive): bool
    {
        $db = Database::connection();

        if ($isActive === 1) {
            $deactivateStmt = $db->prepare('UPDATE promotions SET is_active = 0 WHERE airline_id = :airline_id AND id != :id');
            $deactivateStmt->execute([
                'airline_id' => $airlineId,
                'id' => $id,
            ]);
        }

        $sql = 'UPDATE promotions SET airline_id = :airline_id, title = :title, description = :description, discount_percent = :discount_percent, is_active = :is_active WHERE id = :id';
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'airline_id' => $airlineId,
            'title' => $title,
            'description' => $description,
            'discount_percent' => $discount,
            'is_active' => $isActive,
        ]);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::connection()->prepare('DELETE FROM promotions WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public static function setStatus(int $id, string $status): bool
    {
        $db = Database::connection();
        $promoStmt = $db->prepare('SELECT airline_id FROM promotions WHERE id = :id');
        $promoStmt->execute(['id' => $id]);
        $promo = $promoStmt->fetch();

        if (!$promo) {
            return false;
        }

        $isActive = $status === 'approved' ? 1 : 0;

        if ($isActive === 1) {
            $deactivateStmt = $db->prepare('UPDATE promotions SET is_active = 0 WHERE airline_id = :airline_id AND id != :id');
            $deactivateStmt->execute([
                'airline_id' => (int) $promo['airline_id'],
                'id' => $id,
            ]);
        }

        $sql = 'UPDATE promotions SET status = :status, is_active = :is_active WHERE id = :id';
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'status' => $status,
            'is_active' => $isActive,
        ]);
    }
}
