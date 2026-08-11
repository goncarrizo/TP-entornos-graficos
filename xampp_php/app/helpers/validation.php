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

function valid_name(string $value): bool
{
    $trimmed = trim($value);
    return $trimmed !== '' && (bool) preg_match('/^[\p{L}]{2,}(?:[\s\'\.-][\p{L}]{2,})*$/u', $trimmed);
}

function valid_phone(string $value): bool
{
    return (bool) preg_match('/^[0-9+\-\s]{8,20}$/', trim($value));
}

function valid_document(string $value): bool
{
    return (bool) preg_match('/^[0-9]{7,10}$/', trim($value));
}

function valid_birthdate(string $value): bool
{
    return (bool) preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($value));
}

function valid_email_allowed_domain(string $email): bool
{
    $allowedDomains = ['gmail.com.ar', 'outlook.com', 'outlook.com.ar'];
    $domain = strtolower(substr(strrchr($email, '@'), 1) ?: '');
    return in_array($domain, $allowedDomains, true);
}

function valid_password(string $value): bool
{
    return strlen(trim($value)) >= 6;
}

function int_value($value): int
{
    return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
}

function valid_news_date(string $date): bool
{
    $dateObject = DateTime::createFromFormat('Y-m-d', $date);

    return $dateObject !== false
        && $dateObject->format('Y-m-d') === $date;
}