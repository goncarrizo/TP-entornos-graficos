<?php
require 'app/bootstrap.php';

$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=airarg_db;charset=utf8mb4', 'root', '');
$queries = [
    "SELECT COUNT(*) AS c FROM flights",
    "SELECT COUNT(*) AS c FROM flight_requests WHERE status='pending'",
    "SELECT id, airline_id, origin, destination, departure_time, arrival_time, price, total_seats, available_seats FROM flights ORDER BY id DESC LIMIT 10",
    "SELECT r.id AS reservation_id, r.user_id, r.flight_id, r.seats, r.status, f.origin, f.destination FROM reservations r JOIN flights f ON f.id = r.flight_id ORDER BY r.id DESC LIMIT 20"
];
foreach ($queries as $sql) {
    echo "---\n" . $sql . "\n";
    $stmt = $pdo->query($sql);
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        print_r($row);
        echo "\n";
    }
}

var_dump(Flight::paginated(20, 0));
