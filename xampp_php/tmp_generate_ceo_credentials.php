<?php
// Script para generar credenciales de CEO demo

$demoPassword = "Demo123456";

$airlines = [
    ['id' => 1, 'name' => 'Andes Airlines', 'email' => 'ceo.andes@tp.com'],
    ['id' => 2, 'name' => 'Pampa Fly', 'email' => 'ceo.pampa@tp.com'],
];

echo "=== CREDENCIALES DE LOGIN PARA CEOs DEMO ===\n\n";

$sqlInserts = "-- CEOs Demo - Insertar después de las tablas\n";
$sqlInserts .= "-- Contraseña común: Demo123456\n\n";
$sqlInserts .= "INSERT INTO users (name, email, password_hash, role, airline_id, email_verified, is_approved) VALUES\n";

$lines = [];
foreach ($airlines as $idx => $airline) {
    $hash = password_hash($demoPassword, PASSWORD_DEFAULT);
    $lines[] = "('CEO " . $airline['name'] . "', '" . $airline['email'] . "', '" . $hash . "', 'ceo', " . $airline['id'] . ", 1, 1)";
    
    echo "Aerolínea: " . $airline['name'] . "\n";
    echo "Email: " . $airline['email'] . "\n";
    echo "Contraseña: " . $demoPassword . "\n";
    echo "---\n\n";
}

$sqlInserts .= implode(",\n", $lines) . ";";

echo "\n=== SCRIPT SQL ===\n\n";
echo $sqlInserts . "\n";

// Guardar en archivo
file_put_contents(__DIR__ . '/sql/seed_ceo_demo.sql', $sqlInserts);
echo "\n✓ Script guardado en: sql/seed_ceo_demo.sql\n";
