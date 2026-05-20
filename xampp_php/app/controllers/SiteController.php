<?php

class SiteController
{
    public static function contactSubmit(): void
    {
        $name = clean_text($_POST['name'] ?? '');
        $email = clean_email($_POST['email'] ?? '');
        $subject = clean_text($_POST['subject'] ?? '');
        $message = clean_text($_POST['message'] ?? '');

        if (!valid_name($name) || !valid_email($email) || strlen($subject) < 4 || strlen($message) < 10) {
            flash('error', 'Revisa los datos del formulario de contacto.');
            redirect_to('contact');
        }

        $mailSubject = 'Contacto web AirARG: ' . $subject;
        $mailBody = "Nombre: $name\n"
            . "Email: $email\n"
            . "Asunto: $subject\n\n"
            . "Mensaje:\n$message\n";

        // En local puede guardar fallback en tmp/mail.log si mail() no esta disponible.
        send_app_mail('soporte@airarg.local', $mailSubject, $mailBody);

        flash('ok', 'Recibimos tu consulta. Te vamos a responder a la brevedad.');
        redirect_to('contact');
    }

    public static function systemStatusPage(): void
    {
        require_role('admin');

        $dbOk = false;
        $dbMessage = 'Sin conexion';

        try {
            $stmt = Database::connection()->query('SELECT 1 AS ok');
            $row = $stmt->fetch();
            $dbOk = isset($row['ok']) && (int) $row['ok'] === 1;
            $dbMessage = $dbOk ? 'Conexion activa' : 'Respuesta inesperada';
        } catch (Throwable $e) {
            $dbMessage = 'Error de conexion: ' . $e->getMessage();
        }

        $mailLogPath = __DIR__ . '/../../tmp/mail.log';
        $mailLogExists = file_exists($mailLogPath);

        view('system_status', [
            'status' => [
                'php_version' => PHP_VERSION,
                'db_ok' => $dbOk,
                'db_message' => $dbMessage,
                'server_time' => date('Y-m-d H:i:s'),
                'mail_log_exists' => $mailLogExists,
                'mail_log_path' => 'tmp/mail.log',
            ],
        ]);
    }
}
