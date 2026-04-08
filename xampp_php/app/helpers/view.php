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
