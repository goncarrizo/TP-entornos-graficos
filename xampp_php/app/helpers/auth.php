<?php

// Las sesiones guardan estado del usuario en el servidor.
// A diferencia de una cookie comun, los datos sensibles no viajan completos al navegador.
// El cliente solo mantiene un identificador de sesion, por eso es mas seguro para autenticacion.

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function has_role(string $role): bool
{
    return is_logged_in() && ($_SESSION['user']['role'] === $role);
}

function has_any_role(array $roles): bool
{
    if (!is_logged_in()) {
        return false;
    }

    return in_array($_SESSION['user']['role'], $roles, true);
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: ' . BASE_URL . '/index.php?page=login');
        exit;
    }
}

function require_role(string $role): void
{
    require_login();

    if (!has_role($role)) {
        http_response_code(403);
        echo 'Acceso denegado';
        exit;
    }
}

function require_any_role(array $roles): void
{
    require_login();

    if (!has_any_role($roles)) {
        http_response_code(403);
        echo 'Acceso denegado';
        exit;
    }
}
