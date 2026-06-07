<?php
require __DIR__ . '/../xampp_php/app/config/config.php';

try {
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $stmt = "ALTER TABLE users MODIFY COLUMN password_hash VARCHAR(255) NOT NULL";
    $pdo->exec($stmt);
    echo "Migration 0003 applied (direct ALTER)\n";
} catch (PDOException $ex) {
    echo "Migration failed: " . $ex->getMessage() . "\n";
    exit(1);
}
