<?php

// session_start() habilita el uso de $_SESSION en cada request.
// Se ejecuta al inicio para que todas las paginas/controladores puedan leer el estado de login.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'AirARG');
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/xampp_php/public')), '/');
define('BASE_URL', $basePath === '' ? '/' : $basePath);
// Use environment variables when available (for Docker / cloud deploys)
define('DB_HOST', getenv('DB_HOST') !== false ? getenv('DB_HOST') : '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') !== false ? getenv('DB_PORT') : '3306');
define('DB_NAME', getenv('DB_NAME') !== false ? getenv('DB_NAME') : 'airarg_db');
define('DB_USER', getenv('DB_USER') !== false ? getenv('DB_USER') : 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

// Allow overriding the base URL with an env var (useful in cloud deployments)
if (getenv('APP_URL') !== false && getenv('APP_URL') !== '') {
    $appUrl = rtrim(getenv('APP_URL'), '/');
    define('BASE_URL', parse_url($appUrl, PHP_URL_PATH) ?: '/');
}
