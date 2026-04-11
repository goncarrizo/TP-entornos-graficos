<?php

class AuthController
{
    public static function register(): void
    {
        $name = clean_text($_POST['name'] ?? '');
        $lastname = clean_text($_POST['lastname'] ?? '');
        $email = clean_email($_POST['email'] ?? '');
        $phone = preg_replace('/\s+/', '', (string) ($_POST['phone'] ?? ''));
        $document = preg_replace('/\D+/', '', (string) ($_POST['document'] ?? ''));
        $birthdate = (string) ($_POST['birthdate'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $passwordConfirm = (string) ($_POST['password_confirm'] ?? '');

        $fullName = trim($name . ' ' . $lastname);

        $passwordsMatch = $password !== '' && $password === $passwordConfirm;

        if (!valid_name($name) || !valid_name($lastname) || !valid_email($email) || !valid_phone($phone) || !valid_document($document) || !valid_birthdate($birthdate) || !valid_password($password) || !$passwordsMatch) {
            flash('error', 'Revisa los datos del registro antes de continuar.');
            redirect_to('register');
        }

        if (User::findByEmail($email)) {
            flash('error', 'El email ya existe.');
            redirect_to('register');
        }

        // MD5: hash de una sola via (irreversible en forma directa).
        // Se usa aqui por requerimiento academico, aunque hoy no se recomienda en produccion.
        $hash = md5($password);
        User::create($fullName, $email, $hash);
        send_app_mail($email, 'Registro AirARG', "Hola $fullName, tu cuenta fue creada correctamente.");
        flash('ok', 'Registro exitoso. Ya podes iniciar sesion.');
        redirect_to('login');
    }

    public static function login(): void
    {
        $email = clean_email($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        $user = User::findByEmail($email);

        $hash = md5($password);

        if (!$user || $hash !== $user['password_hash']) {
            flash('error', 'Credenciales invalidas.');
            redirect_to('login');
        }

        if (!(int) $user['email_verified']) {
            flash('error', 'Debes validar tu email.');
            redirect_to('login');
        }

        $_SESSION['user'] = [
            'id_usuario' => (int) $user['id'],
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'nombre' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'rol' => $user['role'],
        ];

        // Claves pedidas de forma explicita en consigna academica.
        $_SESSION['id_usuario'] = (int) $user['id'];
        $_SESSION['nombre'] = $user['name'];
        $_SESSION['rol'] = $user['role'];

        flash('ok', 'Bienvenido/a ' . $user['name']);
        redirect_to('home');
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        session_start();
        flash('ok', 'Sesion cerrada correctamente.');
        redirect_to('home');
    }

    public static function updateProfile(): void
    {
        require_login();

        $user = current_user();
        $userId = (int) ($user['id'] ?? 0);

        $name = clean_text($_POST['name'] ?? '');
        $email = clean_email($_POST['email'] ?? '');

        if (!valid_name($name) || !valid_email($email)) {
            flash('error', 'Revisa los datos de tu cuenta.');
            redirect_to('profile');
        }

        $emailTaken = User::findByEmailExcludingId($email, $userId);
        if ($emailTaken) {
            flash('error', 'Ese email ya esta en uso por otra cuenta.');
            redirect_to('profile');
        }

        User::updateProfile($userId, $name, $email);

        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['nombre'] = $name;
        $_SESSION['user']['email'] = $email;
        $_SESSION['nombre'] = $name;

        flash('ok', 'Tu cuenta fue actualizada correctamente.');
        redirect_to('profile');
    }

    public static function changePassword(): void
    {
        require_login();

        $user = current_user();
        $userId = (int) ($user['id'] ?? 0);
        $email = (string) ($user['email'] ?? '');

        $currentPassword = (string) ($_POST['current_password'] ?? '');
        $newPassword = (string) ($_POST['new_password'] ?? '');
        $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

        if (!valid_password($currentPassword) || !valid_password($newPassword) || $newPassword !== $confirmPassword) {
            flash('error', 'Revisa los datos de cambio de clave.');
            redirect_to('profile');
        }

        $dbUser = User::findByEmail($email);
        if (!$dbUser || md5($currentPassword) !== $dbUser['password_hash']) {
            flash('error', 'La clave actual no es correcta.');
            redirect_to('profile');
        }

        if ($currentPassword === $newPassword) {
            flash('error', 'La nueva clave debe ser diferente a la actual.');
            redirect_to('profile');
        }

        User::updatePassword($userId, md5($newPassword));
        flash('ok', 'Clave actualizada correctamente.');
        redirect_to('profile');
    }
}
