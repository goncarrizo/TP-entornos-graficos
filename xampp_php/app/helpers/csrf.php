<?php

function csrf_token(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        // session should normally be started in config.php
        @session_start();
    }

    if (!isset($_SESSION['_csrf'])) {
        try {
            $_SESSION['_csrf'] = bin2hex(random_bytes(24));
        } catch (Error | Exception $e) {
            // fallback
            $_SESSION['_csrf'] = bin2hex(openssl_random_pseudo_bytes(24));
        }
    }

    return $_SESSION['_csrf'];
}

function check_csrf(?string $token): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }

    if (!is_string($token) || !isset($_SESSION['_csrf'])) {
        return false;
    }

    return hash_equals($_SESSION['_csrf'], $token);
}
