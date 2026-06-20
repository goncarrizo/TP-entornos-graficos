<?php
// Archivo: public/admin_seed_ceos.php
// Acceder desde: http://localhost:8000/admin_seed_ceos.php
// ELIMINAR DESPUÉS DE USAR

require __DIR__ . '/../app/bootstrap.php';

// Solo permitir en desarrollo
if ($_SERVER['HTTP_HOST'] !== 'localhost:8000' && $_SERVER['HTTP_HOST'] !== 'localhost' && strpos($_SERVER['HTTP_HOST'], '127.0.0.1') === false) {
    die('Acceso denegado');
}

$demoPassword = 'Demo123456';

// Datos de aerolíneas
$airlines = [
    ['id' => 1, 'name' => 'Andes Airlines'],
    ['id' => 2, 'name' => 'Pampa Fly'],
];

echo '<h1>Generador de CEOs Demo</h1>';
echo '<pre>';

if ($_POST['action'] === 'generate') {
    try {
        // Eliminar CEOs anteriores (opcional)
        // Database::connection()->query('DELETE FROM users WHERE role = "ceo"');
        
        foreach ($airlines as $airline) {
            $name = 'CEO ' . $airline['name'];
            $email = 'ceo.' . strtolower(str_replace(' ', '', $airline['name'])) . '@demo.com';
            $hash = password_hash($demoPassword, PASSWORD_DEFAULT);
            $airlineId = $airline['id'];
            
            // Verificar si ya existe
            $existing = User::findByEmail($email);
            
            if ($existing) {
                echo "✓ CEO para {$airline['name']} ya existe: {$email}\n";
            } else {
                $success = User::create($name, $email, '+54 11 0000 0000', '00000000', '1990-01-01', $hash, 'ceo', $airlineId, true);
                if ($success) {
                    echo "✓ CEO creado para {$airline['name']}: {$email}\n";
                } else {
                    echo "✗ Error al crear CEO para {$airline['name']}\n";
                }
            }
        }
        
        echo "\n=== CREDENCIALES DE LOGIN ===\n\n";
        foreach ($airlines as $airline) {
            $email = 'ceo.' . strtolower(str_replace(' ', '', $airline['name'])) . '@demo.com';
            echo "Aerolínea: {$airline['name']}\n";
            echo "Email: {$email}\n";
            echo "Contraseña: {$demoPassword}\n";
            echo "---\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Haz clic en el botón para generar CEOs demo:\n\n";
    echo '<form method="post">' . "\n";
    echo '<input type="hidden" name="action" value="generate">' . "\n";
    echo '<button type="submit">Generar CEOs Demo</button>' . "\n";
    echo '</form>';
}

echo '</pre>';
?>
