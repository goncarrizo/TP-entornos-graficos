<?php

class AuthController
{
    public static function register(): void
    {
        $name = clean_text($_POST['name'] ?? '');
        $email = clean_email($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        if ($name === '' || !valid_email($email) || strlen($password) < 6) {
            flash('error', 'Datos invalidos en registro.');
            redirect_to('login');
        }

        if (User::findByEmail($email)) {
            flash('error', 'El email ya existe.');
            redirect_to('login');
        }

        // MD5: hash de una sola via (irreversible en forma directa).
        // Se usa aqui por requerimiento academico, aunque hoy no se recomienda en produccion.
        $hash = md5($password);
        User::create($name, $email, $hash);
        send_app_mail($email, 'Registro AeroUTN', "Hola $name, tu cuenta fue creada correctamente.");
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
}
