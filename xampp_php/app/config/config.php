<?php

// session_start() habilita el uso de $_SESSION en cada request.
// Se ejecuta al inicio para que todas las paginas/controladores puedan leer el estado de login.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'AeroUTN');
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/xampp_php/public')), '/');
define('BASE_URL', $basePath === '' ? '/' : $basePath);
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'tp_entornos_graficos_php');
define('DB_USER', 'root');
define('DB_PASS', '');
