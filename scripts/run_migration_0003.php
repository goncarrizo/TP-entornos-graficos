<?php
require __DIR__ . '/../xampp_php/app/config/config.php';

try {
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $sql = file_get_contents(__DIR__ . '/../xampp_php/sql/migrations/0003_password_hash_length.sql');
    $parts = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($parts as $part) {
        $part = trim($part);
        if ($part === '' || strpos($part, '--') === 0) {
            continue;
        }
        // Skip USE statements — we already connect to the target DB
        if (preg_match('/^USE\s+/i', $part)) {
            continue;
        }
        $stmt = rtrim($part, "\r\n \t;");
        if ($stmt === '') continue;
        $pdo->exec($stmt);
        echo "Executed: " . substr($stmt, 0, 120) . "\n";
    }

    echo "Migration 0003 applied successfully.\n";
} catch (PDOException $ex) {
    echo "Migration failed: " . $ex->getMessage() . "\n";
    exit(1);
}
