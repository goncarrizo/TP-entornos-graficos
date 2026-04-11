<?php

function send_app_mail(string $to, string $subject, string $message): bool
{
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/plain; charset=utf-8',
        'From: no-reply@airarg.local',
    ];

    $sent = @mail($to, $subject, $message, implode("\r\n", $headers));

    if (!$sent) {
        // Fallback academico para XAMPP: guarda salida de mail en archivo local.
        $logDir = __DIR__ . '/../../tmp';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0775, true);
        }

        $line = '[' . date('Y-m-d H:i:s') . '] TO: ' . $to . ' | SUBJECT: ' . $subject . PHP_EOL . $message . PHP_EOL . str_repeat('-', 50) . PHP_EOL;
        file_put_contents($logDir . '/mail.log', $line, FILE_APPEND);
    }

    return $sent;
}
