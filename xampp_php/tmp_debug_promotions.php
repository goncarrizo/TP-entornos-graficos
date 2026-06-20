<?php
require __DIR__ . '/app/bootstrap.php';

$db = Database::connection();

$stmt = $db->query("SELECT p.id, p.airline_id, p.title, p.description, p.discount_percent, p.status, p.is_active, a.name AS airline_name FROM promotions p JOIN airlines a ON a.id = p.airline_id ORDER BY p.id");
$rows = $stmt->fetchAll();

foreach ($rows as $row) {
    echo json_encode($row, JSON_UNESCAPED_UNICODE) . PHP_EOL;
}

echo 'COUNT=' . count($rows) . PHP_EOL;

// Try to activate approved promos explicitly.
Promotion::setStatus(4, 'approved');

$stmt = $db->query("SELECT p.id, p.airline_id, p.title, p.description, p.discount_percent, p.status, p.is_active, a.name AS airline_name FROM promotions p JOIN airlines a ON a.id = p.airline_id ORDER BY p.id");
$rows = $stmt->fetchAll();

echo PHP_EOL . 'AFTER UPDATE' . PHP_EOL;
foreach ($rows as $row) {
    echo json_encode($row, JSON_UNESCAPED_UNICODE) . PHP_EOL;
}
