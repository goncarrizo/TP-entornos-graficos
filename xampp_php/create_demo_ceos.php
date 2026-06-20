<?php
// Script para generar CEOs demo directamente en la base de datos
// Ejecutar SOLO UNA VEZ con: php create_demo_ceos.php

require __DIR__ . '/app/bootstrap.php';

$demoPassword = 'Demo123456';

$ceos = [
    [
        'name' => 'CEO Andes Airlines',
        'email' => 'ceo.andes@demo.com',
        'airline_id' => 1
    ],
    [
        'name' => 'CEO Pampa Fly',
        'email' => 'ceo.pampa@demo.com',
        'airline_id' => 2
    ]
];

echo "========================================\n";
echo "  GENERADOR DE CEOs DEMO\n";
echo "========================================\n\n";

foreach ($ceos as $ceo) {
    // Verificar si ya existe
    $existing = User::findByEmail($ceo['email']);
    
    if ($existing) {
        echo "❌ {$ceo['name']} ya existe con email: {$ceo['email']}\n";
    } else {
        // Generar hash
        $hash = password_hash($demoPassword, PASSWORD_DEFAULT);
        
        // Crear CEO
        $created = User::create(
            $ceo['name'],
            $ceo['email'],
            '+54 11 0000 0000',
            '00000000',
            '1990-01-01',
            $hash,
            'ceo',
            $ceo['airline_id'],
            true // is_approved = true
        );
        
        if ($created) {
            echo "✅ CEO creado: {$ceo['name']}\n";
            echo "   Email: {$ceo['email']}\n";
            echo "   Aerolínea ID: {$ceo['airline_id']}\n";
        } else {
            echo "❌ Error al crear CEO: {$ceo['name']}\n";
        }
    }
}

echo "\n========================================\n";
echo "  CREDENCIALES DE LOGIN\n";
echo "========================================\n\n";

foreach ($ceos as $ceo) {
    echo "Aerolínea: {$ceo['name']}\n";
    echo "Email: {$ceo['email']}\n";
    echo "Contraseña: {$demoPassword}\n";
    echo "---\n";
}

echo "\n✓ Script finalizado\n";
