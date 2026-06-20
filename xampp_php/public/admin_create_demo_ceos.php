<?php
/**
 * Generador de CEOs Demo - Accesible desde el navegador
 * Acceder a: http://localhost/admin_create_demo_ceos.php
 * 
 * ELIMINAR DESPUÉS DE USAR POR SEGURIDAD
 */

// Solo permitir acceso local
$allowedHosts = ['localhost', '127.0.0.1', '::1'];
$isLocal = in_array($_SERVER['HTTP_HOST'] ?? '', $allowedHosts) || 
           in_array(explode(':', $_SERVER['HTTP_HOST'] ?? '')[0], $allowedHosts);

if (!$isLocal) {
    http_response_code(403);
    die('Acceso denegado. Solo permitido en localhost.');
}

require __DIR__ . '/app/bootstrap.php';

$demoPassword = 'Demo123456';
$message = '';
$success = false;

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'create') {
    $message = '<div style="background: #f0f0f0; padding: 20px; border-radius: 5px; font-family: monospace;">';
    $message .= '<h3>Resultado:</h3>';
    
    $createdCount = 0;
    $existsCount = 0;
    
    foreach ($ceos as $ceo) {
        $existing = User::findByEmail($ceo['email']);
        
        if ($existing) {
            $message .= "<p>❌ <strong>{$ceo['name']}</strong> ya existe</p>";
            $existsCount++;
        } else {
            $hash = password_hash($demoPassword, PASSWORD_DEFAULT);
            
            $created = User::create(
                $ceo['name'],
                $ceo['email'],
                '+54 11 0000 0000',
                '00000000',
                '1990-01-01',
                $hash,
                'ceo',
                $ceo['airline_id'],
                true
            );
            
            if ($created) {
                $message .= "<p>✅ CEO creado: <strong>{$ceo['name']}</strong></p>";
                $message .= "<p style='margin-left: 20px; color: #666;'>Email: {$ceo['email']}</p>";
                $createdCount++;
            } else {
                $message .= "<p>❌ Error al crear: <strong>{$ceo['name']}</strong></p>";
            }
        }
    }
    
    $message .= "<hr style='margin: 20px 0;'>";
    $message .= "<p><strong>Resumen:</strong> $createdCount creados, $existsCount ya existían</p>";
    $message .= '</div>';
    $success = true;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de CEOs Demo</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #555;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .ceo-item {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }
        .ceo-item strong {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }
        .ceo-item p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        button:hover {
            background: #218838;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            color: #856404;
            margin-bottom: 20px;
        }
        .message {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Generador de CEOs Demo</h1>
        
        <div class="warning">
            <strong>⚠️ Importante:</strong> Este archivo debe ser eliminado después de usarlo por seguridad.
        </div>

        <?php if ($success): ?>
            <?php echo $message; ?>
        <?php endif; ?>

        <div class="section">
            <h2>Información de CEOs a crear:</h2>
            <?php foreach ($ceos as $ceo): ?>
                <div class="ceo-item">
                    <strong><?php echo htmlspecialchars($ceo['name']); ?></strong>
                    <p>Email: <code><?php echo htmlspecialchars($ceo['email']); ?></code></p>
                    <p>Contraseña: <code><?php echo $demoPassword; ?></code></p>
                    <p>Aerolínea ID: <?php echo (int) $ceo['airline_id']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="POST">
            <input type="hidden" name="action" value="create">
            <button type="submit">Crear CEOs Demo</button>
        </form>
    </div>
</body>
</html>
