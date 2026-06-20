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
        $sql = 'SELECT id, name, email, role, email_verified, user_icon, airline_id, is_approved FROM users WHERE id = :id LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public static function create(string $name, string $email, string $phone, string $documentNumber, string $birthdate, string $passwordHash, string $role = 'customer', ?int $airlineId = null, bool $isApproved = true): bool
    {
        $sql = 'INSERT INTO users (name, email, phone, document_number, birthdate, password_hash, role, airline_id, email_verified, is_approved) VALUES (:name, :email, :phone, :document_number, :birthdate, :password_hash, :role, :airline_id, :email_verified, :is_approved)';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'document_number' => $documentNumber,
            'birthdate' => $birthdate,
            'password_hash' => $passwordHash,
            'role' => $role,
            'airline_id' => $airlineId,
            'email_verified' => 1,
            'is_approved' => $isApproved ? 1 : 0,
        ]);
    }

    public static function findByAirlineAndRole(int $airlineId, string $role): ?array
    {
        $sql = 'SELECT id, name, email, role, airline_id FROM users WHERE airline_id = :airline_id AND role = :role LIMIT 1';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['airline_id' => $airlineId, 'role' => $role]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public static function allByRole(string $role): array
    {
        $sql = 'SELECT u.*, a.name AS airline_name FROM users u LEFT JOIN airlines a ON a.id = u.airline_id WHERE u.role = :role ORDER BY u.name ASC';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['role' => $role]);
        return $stmt->fetchAll();
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

    public static function updateIcon(int $id, ?string $iconKey): bool
    {
        $sql = 'UPDATE users SET user_icon = :user_icon WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'user_icon' => $iconKey,
        ]);
    }

    public static function getPendingCEOs(): array
    {
        $sql = 'SELECT u.*, a.name AS airline_name FROM users u LEFT JOIN airlines a ON a.id = u.airline_id WHERE u.role = :role AND u.is_approved = 0 ORDER BY u.created_at DESC';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['role' => 'ceo']);
        return $stmt->fetchAll();
    }

    public static function approveCEO(int $id): bool
    {
        $sql = 'UPDATE users SET is_approved = 1 WHERE id = :id AND role = :role';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute(['id' => $id, 'role' => 'ceo']);
    }

    public static function rejectCEO(int $id): bool
    {
        $sql = 'DELETE FROM users WHERE id = :id AND role = :role';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute(['id' => $id, 'role' => 'ceo']);
    }

    public static function getAllApprovedCEOs(): array
    {
        $sql = 'SELECT u.*, a.name AS airline_name FROM users u LEFT JOIN airlines a ON a.id = u.airline_id WHERE u.role = :role AND u.is_approved = 1 ORDER BY u.name ASC';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['role' => 'ceo']);
        return $stmt->fetchAll();
    }
}

