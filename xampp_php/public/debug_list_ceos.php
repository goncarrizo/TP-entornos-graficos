<?php
/**
 * Depurador temporal para listar CEOs en la base de datos
 * Acceder desde: http://localhost/debug_list_ceos.php
 * ELIMINAR DESPUÉS DE USAR
 */

require __DIR__ . '/../app/bootstrap.php';

$ceos = [];
try {
    $stmt = Database::connection()->query("SELECT id, name, email, role, airline_id, is_approved, email_verified, password_hash FROM users WHERE role = 'ceo'");
    $ceos = $stmt->fetchAll();
} catch (Throwable $error) {
    echo '<pre>Error: ' . htmlspecialchars($error->getMessage()) . '</pre>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Debug CEOs</title>
    <style>body{font-family:Arial,sans-serif;padding:20px;}table{border-collapse:collapse;width:100%;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background:#f2f2f2;}</style>
</head>
<body>
    <h1>CEOs en la base de datos</h1>
    <p>Elimina este archivo después de usarlo.</p>
    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Aerolínea</th><th>Aprobado</th><th>Email verificado</th><th>Hash</th></tr>
        </thead>
        <tbody>
            <?php foreach ($ceos as $ceo): ?>
                <tr>
                    <td><?php echo (int)$ceo['id']; ?></td>
                    <td><?php echo htmlspecialchars($ceo['name']); ?></td>
                    <td><?php echo htmlspecialchars($ceo['email']); ?></td>
                    <td><?php echo (int)$ceo['airline_id']; ?></td>
                    <td><?php echo (int)$ceo['is_approved']; ?></td>
                    <td><?php echo (int)$ceo['email_verified']; ?></td>
                    <td><?php echo htmlspecialchars($ceo['password_hash']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
