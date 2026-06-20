<?php
require 'app/bootstrap.php';

$pdo = Database::connection();
$flightId = 5;

$beforeReservations = (int) $pdo->query('SELECT COUNT(*) FROM reservations WHERE flight_id = ' . $flightId)->fetchColumn();
$beforeFlights = (int) $pdo->query('SELECT COUNT(*) FROM flights WHERE id = ' . $flightId)->fetchColumn();

echo "Before: flight_exists=$beforeFlights, reservations=$beforeReservations\n";

$result = Flight::delete($flightId);

echo 'Delete result=' . ($result ? 'true' : 'false') . "\n";

$afterReservations = (int) $pdo->query('SELECT COUNT(*) FROM reservations WHERE flight_id = ' . $flightId)->fetchColumn();
$afterFlights = (int) $pdo->query('SELECT COUNT(*) FROM flights WHERE id = ' . $flightId)->fetchColumn();

echo "After: flight_exists=$afterFlights, reservations=$afterReservations\n";
