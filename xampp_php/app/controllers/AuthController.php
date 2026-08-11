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
        $role = clean_text($_POST['role'] ?? 'customer');
        $airlineId = int_value($_POST['airline_id'] ?? 0);

        $fullName = trim($name . ' ' . $lastname);

        $passwordsMatch = $password !== '' && $password === $passwordConfirm;

        /*
        * Guardamos los datos que se pueden recuperar si hay errores.
        * NO guardamos las contraseñas.
        */
        $_SESSION['register_old'] = [
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
            'document' => $document,
            'birthdate' => $birthdate,
            'role' => $role,
            'airline_id' => $airlineId > 0 ? $airlineId : '',
        ];

        $errors = [];

        // Nombre
        if ($name === '') {
            $errors['name'] = 'El nombre es obligatorio.';
        } elseif (!valid_name($name)) {
            $errors['name'] = 'Ingresa un nombre valido.';
        }

        // Apellido
        if (!valid_name($lastname)) {
            $errors['lastname'] = 'Ingresa un apellido valido.';
        }

        // Email
        if ($email === '') {
            $errors['email'] = 'Campo obligatorio.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Ingresa un email válido.';
        } elseif (!preg_match('/^[A-Za-z0-9._%+-]+@(gmail\.com|outlook\.com|outlook\.com\.ar)$/i', $email)) {
            $errors['email'] = 'El email debe terminar en @gmail.com, @outlook.com o @outlook.com.ar.';
        }

        // Telefono
        if (!valid_phone($phone)) {
            $errors['phone'] = 'Ingresa un telefono valido.';
        }

        // Documento
        if (!valid_document($document)) {
            $errors['document'] = 'Ingresa un documento valido (7 a 10 digitos).';
        }

        // Fecha de nacimiento
        if (!valid_birthdate($birthdate)) {
            $errors['birthdate'] = 'Ingresa una fecha de nacimiento valida.';
        }

        // Clave
        if (!valid_password($password)) {
            $errors['password'] = 'La clave debe tener al menos 6 caracteres.';
        }

        // Confirmación de clave
        if (!$passwordsMatch) {
            $errors['password_confirm'] = 'Las claves no coinciden.';
        }

        // Rol
        if ($role !== 'customer' && $role !== 'ceo') {
            $errors['role'] = 'Selecciona un tipo de cuenta valido.';
        }

        // Aerolínea para CEO
        if ($role === 'ceo') {
            if ($airlineId < 1) {
                $errors['airline_id'] = 'Debes seleccionar una aerolinea.';
            } elseif (!Airline::findById($airlineId)) {
                $errors['airline_id'] = 'La aerolinea seleccionada no es valida.';
            } elseif (User::findByAirlineAndRole($airlineId, 'ceo')) {
                $errors['airline_id'] = 'Ya existe un CEO asignado a esa aerolinea.';
            }
        }

        /*
        * Si existen errores, los guardamos en sesión y volvemos
        * al formulario.
        */
        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;

            flash('error', 'Revisa los campos marcados para continuar.');
            redirect_to('register');
        }

        /*
        * Verificamos el email después de las validaciones.
        */
        if (User::findByEmail($email)) {
            $_SESSION['register_errors'] = [
                'email' => 'Este email ya está registrado.'
            ];

            flash('error', 'Revisa el campo email.');
            redirect_to('register');
        }

        // Password segura
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $isApproved = true;

        if ($role === 'ceo') {
            // Los CEOs creados por usuarios que no son administradores
            // requieren aprobación.
            $isApproved = is_logged_in() && has_role('admin');
        } else {
            $airlineId = null;
        }

        User::create(
            $fullName,
            $email,
            $phone,
            $document,
            $birthdate,
            $hash,
            $role,
            $airlineId,
            $isApproved
        );

        /*
        * El registro fue exitoso, por lo tanto ya no necesitamos
        * mantener los datos anteriores.
        */
        unset($_SESSION['register_old'], $_SESSION['register_errors']);

        if ($role === 'ceo' && !$isApproved) {
            flash(
                'ok',
                'Solicitud de CEO enviada. Debes esperar la aprobación del administrador para acceder.'
            );
        } else {
            $mailSent = send_app_mail(
                $email,
                'Registro AirARG',
                "Hola $fullName, tu cuenta fue creada correctamente."
            );

            if ($mailSent) {
                flash('ok', 'Registro exitoso. Ya podes iniciar sesion.');
            } else {
                flash(
                    'ok',
                    'Registro exitoso. Ya podes iniciar sesion. El correo de bienvenida no pudo enviarse desde este entorno.'
                );
            }
        }

        redirect_to('login');
    }

    public static function login(): void
    {
        $email = clean_email($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        $user = User::findByEmail($email);

        $dbHash = $user['password_hash'] ?? '';

        $passwordValid = false;
        // First try modern verify
        if (!empty($dbHash) && password_verify($password, $dbHash)) {
            $passwordValid = true;
            // Rehash if algo changed
            if (password_needs_rehash($dbHash, PASSWORD_DEFAULT)) {
                User::updatePassword((int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
            }
        }

        // Fallback for legacy MD5 hashes: if stored hash is 32 chars and md5 matches, migrate it.
        if (!$passwordValid && is_string($dbHash) && strlen($dbHash) === 32 && md5($password) === $dbHash) {
            $passwordValid = true;
            // Migrate to password_hash
            User::updatePassword((int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
        }

        if (!$user || !$passwordValid) {
            flash('error', 'Credenciales invalidas.');
            redirect_to('login');
        }

        if (!(int) $user['email_verified']) {
            flash('error', 'Debes validar tu email.');
            redirect_to('login');
        }

        // Block unapproved CEOs
        if ($user['role'] === 'ceo' && !(int) ($user['is_approved'] ?? 1)) {
            flash('error', 'Tu cuenta de CEO aun no ha sido aprobada por el administrador.');
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
            'airline_id' => $user['airline_id'] ?? null,
            'user_icon' => $user['user_icon'] ?? null,
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

    public static function requestPasswordReset(): void
    {
        $email = clean_email($_POST['email'] ?? '');
        if (!valid_email($email)) {
            flash('error', 'Ingresa un email valido para recuperar la clave.');
            redirect_to('login');
        }

        $user = User::findByEmail($email);
        if (!$user) {
            // No revelar si el email existe para mayor seguridad.
            flash('ok', 'Si el email existe en el sistema, recibirás una clave temporal en tu correo.');
            redirect_to('login');
        }

        if ($user['role'] === 'ceo' && !(int) ($user['is_approved'] ?? 1)) {
            flash('error', 'Tu cuenta de CEO aun no ha sido aprobada. No es posible restablecer la clave hasta que el administrador la apruebe.');
            redirect_to('login');
        }

        $temporaryPassword = bin2hex(random_bytes(5));
        $hashedTempPassword = password_hash($temporaryPassword, PASSWORD_DEFAULT);
        if (!User::updatePassword((int) $user['id'], $hashedTempPassword)) {
            flash('error', 'No se pudo procesar la solicitud de restablecimiento. Intenta de nuevo mas tarde.');
            redirect_to('login');
        }

        $message = "Hola {$user['name']},\n\n" .
            "Se solicitó recuperar la contraseña de tu cuenta. Tu nueva clave temporal es:\n\n" .
            "$temporaryPassword\n\n" .
            "Usa esta clave para iniciar sesión y luego cambia tu contraseña desde tu perfil.\n\n" .
            "Si no solicitaste este cambio, ignora este correo.";
        $mailSent = send_app_mail($email, 'Recuperacion de contraseña AirARG', $message);

        if ($mailSent) {
            flash('ok', 'Se envió una clave temporal a tu correo. Revisa tu bandeja y luego inicia sesión.');
        } else {
            flash('error', 'No se pudo enviar el correo de recuperación. Contacta al administrador o intenta nuevamente.');
        }

        redirect_to('login');
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

    public static function updateIcon(): void
    {
        require_login();

        $user = current_user();
        $userId = (int) ($user['id'] ?? 0);

        $icon = clean_text((string) ($_POST['user_icon'] ?? ''));

        $allowed = [
            'plane',
            'ticket',
            'map',
            'shield',
            'star',
            'heart',
            'user',
            'globe',
        ];

        if ($userId < 1) {
            flash('error', 'Usuario invalido.');
            redirect_to('account_edit');
        }

        if ($icon !== '' && !in_array($icon, $allowed, true)) {
            flash('error', 'Icono invalido.');
            redirect_to('account_edit');
        }

        // Permite vaciar el icono si llega ''
        $iconKey = $icon !== '' ? $icon : null;

        if (!User::updateIcon($userId, $iconKey)) {
            flash('error', 'No se pudo actualizar el icono.');
            redirect_to('account_edit');
        }

        $_SESSION['user']['user_icon'] = $iconKey;

        // Asegura que navbar/profile reflejen el cambio en la sesion actual.
        flash('ok', 'Icono actualizado correctamente.');
        redirect_to('account_edit');
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
        $dbHash = $dbUser['password_hash'] ?? '';
        $currentValid = false;
        if (!empty($dbHash) && password_verify($currentPassword, $dbHash)) {
            $currentValid = true;
        }
        // Legacy md5 support
        if (!$currentValid && is_string($dbHash) && strlen($dbHash) === 32 && md5($currentPassword) === $dbHash) {
            $currentValid = true;
        }
        if (!$dbUser || !$currentValid) {
            flash('error', 'La clave actual no es correcta.');
            redirect_to('profile');
        }

        if ($currentPassword === $newPassword) {
            flash('error', 'La nueva clave debe ser diferente a la actual.');
            redirect_to('profile');
        }

        User::updatePassword($userId, password_hash($newPassword, PASSWORD_DEFAULT));
        flash('ok', 'Clave actualizada correctamente.');
        redirect_to('profile');
    }
}
