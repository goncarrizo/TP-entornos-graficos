<?php

class Airline
{
    public static function all(): array
    {
        $stmt = Database::connection()->query('SELECT * FROM airlines ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public static function findByCode(string $code): ?array
    {
        $sql = 'SELECT * FROM airlines WHERE code = :code LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['code' => $code]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(string $name, string $code, string $country): bool
    {
        $sql = 'INSERT INTO airlines (name, code, country) VALUES (:name, :code, :country)';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute(compact('name', 'code', 'country'));
    }

    public static function update(int $id, string $name, string $code, string $country): bool
    {
        $sql = 'UPDATE airlines SET name = :name, code = :code, country = :country WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute(compact('id', 'name', 'code', 'country'));
    }

    public static function delete(int $id): bool
    {
        $sql = 'DELETE FROM airlines WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
