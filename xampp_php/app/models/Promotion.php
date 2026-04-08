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
            'is_active' => 1,
        ]);
    }

    public static function update(int $id, int $airlineId, string $title, string $description, float $discount, int $isActive): bool
    {
        $sql = 'UPDATE promotions SET airline_id = :airline_id, title = :title, description = :description, discount_percent = :discount_percent, is_active = :is_active WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);

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
        $sql = 'UPDATE promotions SET status = :status WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }
}
