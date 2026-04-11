<?php

class Favorite
{
    public static function idsByUser(int $userId): array
    {
        $sql = 'SELECT flight_id FROM user_favorites WHERE user_id = :user_id';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        return array_map('intval', array_column($stmt->fetchAll(), 'flight_id'));
    }

    public static function exists(int $userId, int $flightId): bool
    {
        $sql = 'SELECT 1 FROM user_favorites WHERE user_id = :user_id AND flight_id = :flight_id LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'flight_id' => $flightId,
        ]);

        return (bool) $stmt->fetch();
    }

    public static function add(int $userId, int $flightId): bool
    {
        $sql = 'INSERT INTO user_favorites (user_id, flight_id) VALUES (:user_id, :flight_id)';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'user_id' => $userId,
            'flight_id' => $flightId,
        ]);
    }

    public static function remove(int $userId, int $flightId): bool
    {
        $sql = 'DELETE FROM user_favorites WHERE user_id = :user_id AND flight_id = :flight_id';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'user_id' => $userId,
            'flight_id' => $flightId,
        ]);
    }

    public static function toggle(int $userId, int $flightId): bool
    {
        if (self::exists($userId, $flightId)) {
            self::remove($userId, $flightId);
            return false;
        }

        self::add($userId, $flightId);
        return true;
    }

    public static function flightsByUser(int $userId, int $limit = 4): array
    {
        $sql = "SELECT f.*, a.name AS airline_name
                FROM user_favorites uf
                JOIN flights f ON f.id = uf.flight_id
                JOIN airlines a ON a.id = f.airline_id
                WHERE uf.user_id = :user_id
                ORDER BY uf.created_at DESC
                LIMIT :limit";

        $stmt = Database::connection()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
