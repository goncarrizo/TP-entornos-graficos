<?php

function view(string $page, array $data = []): void
{
    extract($data);

    require __DIR__ . '/../views/partials/header.php';

    require __DIR__ . '/../views/partials/navbar.php';

    require __DIR__ . '/../views/pages/' . $page . '.php';

    require __DIR__ . '/../views/partials/footer.php';
}

function redirect_to(string $page): void
{
    header('Location: ' . BASE_URL . '/index.php?page=' . $page);
    exit;
}

function flash(string $key, ?string $value = null): ?string
{
    // Aseguramos que flash exista como array para evitar "null as an array offset"
    if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }

    if ($value !== null) {
        $_SESSION['flash'][$key] = $value;
        return null;
    }

    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $message;
}

function paginate(int $totalItems, int $perPage, int $currentPage): array
{
    $totalPages = max(1, (int) ceil($totalItems / $perPage));
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $perPage;

    return [
        'total_pages' => $totalPages,
        'current_page' => $currentPage,
        'offset' => $offset,
        'limit' => $perPage,
    ];
}

function news_old(string $field): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $values = [];
    if (isset($GLOBALS['news_old_values']) && is_array($GLOBALS['news_old_values'])) {
        $values = $GLOBALS['news_old_values'];
    } elseif (isset($_SESSION['news_old']) && is_array($_SESSION['news_old'])) {
        $values = $_SESSION['news_old'];
    }

    return htmlspecialchars(
        $values[$field] ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}

function news_error(string $field): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $errors = [];
    if (isset($GLOBALS['news_errors']) && is_array($GLOBALS['news_errors'])) {
        $errors = $GLOBALS['news_errors'];
    } elseif (isset($_SESSION['news_errors']) && is_array($_SESSION['news_errors'])) {
        $errors = $_SESSION['news_errors'];
    }

    if (isset($errors[$field])) {
        return '<div class="text-danger small mt-1" role="alert" style="display:block;">'
            . htmlspecialchars($errors[$field], ENT_QUOTES, 'UTF-8')
            . '</div>';
    }

    return '';
}

function news_invalid_class(string $field): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $errors = [];
    if (isset($GLOBALS['news_errors']) && is_array($GLOBALS['news_errors'])) {
        $errors = $GLOBALS['news_errors'];
    } elseif (isset($_SESSION['news_errors']) && is_array($_SESSION['news_errors'])) {
        $errors = $_SESSION['news_errors'];
    }

    if (isset($errors[$field])) {
        return ' is-invalid';
    }

    return '';
}
