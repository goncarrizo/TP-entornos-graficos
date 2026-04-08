<?php

class User
{
    public static function findByEmail(string $email): ?array
    {
        $sql = 'SELECT * FROM users WHERE email = :email LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public static function findById(int $id): ?array
    {
        $sql = 'SELECT id, name, email, role, email_verified FROM users WHERE id = :id LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public static function create(string $name, string $email, string $passwordHash): bool
    {
        $sql = 'INSERT INTO users (name, email, password_hash, role, email_verified) VALUES (:name, :email, :password_hash, :role, :email_verified)';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
            'role' => 'customer',
            'email_verified' => 1,
        ]);
    }

    public static function countAll(): int
    {
        $stmt = Database::connection()->query('SELECT COUNT(*) AS c FROM users');
        $row = $stmt->fetch();
        return (int) $row['c'];
    }
}
