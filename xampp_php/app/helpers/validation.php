<?php

function clean_text(?string $value): string
{
    return trim((string) $value);
}

function clean_email(?string $value): string
{
    return filter_var(trim((string) $value), FILTER_SANITIZE_EMAIL) ?: '';
}

function valid_email(string $email): bool
{
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

function int_value($value): int
{
    return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
}
