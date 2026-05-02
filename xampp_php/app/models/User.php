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

    public static function create(string $name, string $email, string $phone, string $documentNumber, string $birthdate, string $passwordHash): bool
    {
        $sql = 'INSERT INTO users (name, email, phone, document_number, birthdate, password_hash, role, email_verified) VALUES (:name, :email, :phone, :document_number, :birthdate, :password_hash, :role, :email_verified)';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'document_number' => $documentNumber,
            'birthdate' => $birthdate,
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

    public static function findByEmailExcludingId(string $email, int $excludeId): ?array
    {
        $sql = 'SELECT id, name, email FROM users WHERE email = :email AND id <> :id LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['email' => $email, 'id' => $excludeId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public static function updateProfile(int $id, string $name, string $email): bool
    {
        $sql = 'UPDATE users SET name = :name, email = :email WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
        ]);
    }

    public static function updatePassword(int $id, string $passwordHash): bool
    {
        $sql = 'UPDATE users SET password_hash = :password_hash WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'password_hash' => $passwordHash,
        ]);
    }
}
