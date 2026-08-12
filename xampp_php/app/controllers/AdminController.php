<?php

class AdminController
{
    public static function exportSalesCsv(): void
    {
        require_role('admin');

        $rows = Report::salesByAirline();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="reporte_ventas_admin.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['Aerolinea', 'Ventas confirmadas']);
        foreach ($rows as $row) {
            fputcsv($out, [$row['airline'], (float) $row['total_sales']]);
        }
        fclose($out);
        exit;
    }

    public static function panel(?array $newsErrors = null, array $newsOld = []): void
    {
        require_role('admin');

        $airlines = Airline::all();
        $promotions = Promotion::all();
        $news = News::all();
        $reports = Report::general();
        $sales = Report::salesByAirline();
        $pendingAirlineRequests = AirlineRequest::allPending();
        $pendingFlightRequests = FlightRequest::allPending();
        $pendingCEOs = User::getPendingCEOs();

        if ($newsErrors !== null) {
            $_SESSION['create_news_errors'] = $newsErrors;
            $_SESSION['create_news_old'] = $newsOld;
            $GLOBALS['create_news_errors'] = $newsErrors;
            $GLOBALS['create_news_old_values'] = $newsOld;
        } else {
            $newsErrors = $_SESSION['create_news_errors'] ?? [];
            $newsOld = $_SESSION['create_news_old'] ?? [];
            $GLOBALS['create_news_errors'] = $newsErrors;
            $GLOBALS['create_news_old_values'] = $newsOld;
        }

        view('admin', [
            'airlines' => $airlines,
            'promotions' => $promotions,
            'news' => $news,
            'reports' => $reports,
            'sales' => $sales,
            'pendingAirlineRequests' => $pendingAirlineRequests,
            'pendingFlightRequests' => $pendingFlightRequests,
            'pendingCEOs' => $pendingCEOs,
            'newsErrors' => $newsErrors,
            'newsOld' => $newsOld,
            'newsOldValues' => $newsOld,
        ]);
    }

    public static function approveAirlineRequest(): void
    {
        require_role('admin');

        $id = int_value($_POST['airline_request_id'] ?? 0);
        $request = AirlineRequest::find($id);

        if (!$request || $request['status'] !== 'pending') {
            flash('error', 'Solicitud de aerolinea no encontrada o ya procesada.');
            redirect_to('admin');
        }

        if (Airline::findByCode($request['code'])) {
            flash('error', 'Ya existe una aerolinea con ese codigo.');
            redirect_to('admin');
        }

        Airline::create($request['name'], $request['code'], $request['country']);
        AirlineRequest::setStatus($id, 'approved', (int) current_user()['id']);
        flash('ok', 'La propuesta de aerolinea fue aprobada y agregada al sistema.');
        redirect_to('admin');
    }

    public static function denyAirlineRequest(): void
    {
        require_role('admin');

        $id = int_value($_POST['airline_request_id'] ?? 0);
        $request = AirlineRequest::find($id);

        if (!$request || $request['status'] !== 'pending') {
            flash('error', 'Solicitud de aerolinea no encontrada o ya procesada.');
            redirect_to('admin');
        }

        AirlineRequest::setStatus($id, 'denied', (int) current_user()['id']);
        flash('ok', 'La propuesta de aerolinea fue denegada.');
        redirect_to('admin');
    }

    public static function approveFlightRequest(): void
    {
        require_role('admin');

        $id = int_value($_POST['flight_request_id'] ?? 0);
        $request = FlightRequest::find($id);

        if (!$request || $request['status'] !== 'pending') {
            flash('error', 'Solicitud de vuelo no encontrada o ya procesada.');
            redirect_to('admin');
        }

        Flight::create($request);
        FlightRequest::setStatus($id, 'approved', (int) current_user()['id']);
        flash('ok', 'La solicitud de vuelo fue aprobada y el vuelo se agrego al sistema.');
        redirect_to('admin');
    }

    public static function denyFlightRequest(): void
    {
        require_role('admin');

        $id = int_value($_POST['flight_request_id'] ?? 0);
        $request = FlightRequest::find($id);

        if (!$request || $request['status'] !== 'pending') {
            flash('error', 'Solicitud de vuelo no encontrada o ya procesada.');
            redirect_to('admin');
        }

        FlightRequest::setStatus($id, 'denied', (int) current_user()['id']);
        flash('ok', 'La solicitud de vuelo fue denegada.');
        redirect_to('admin');
    }

    public static function approveCEO(): void
    {
        require_role('admin');

        $id = int_value($_POST['ceo_id'] ?? 0);
        $ceo = User::findById($id);

        if (!$ceo || $ceo['role'] !== 'ceo') {
            flash('error', 'CEO no encontrado.');
            redirect_to('admin');
        }

        if (!(int) ($ceo['is_approved'] ?? 1) === 0) {
            flash('error', 'Este CEO ya fue procesado.');
            redirect_to('admin');
        }

        User::approveCEO($id);
        $mailSent = send_app_mail($ceo['email'], 'Solicitud de CEO Aprobada', "Hola {$ceo['name']}, tu solicitud para ser CEO ha sido aprobada. Ya podes iniciar sesion.");
        flash('ok', 'CEO aprobado correctamente.');
        redirect_to('admin');
    }

    public static function rejectCEO(): void
    {
        require_role('admin');

        $id = int_value($_POST['ceo_id'] ?? 0);
        $ceo = User::findById($id);

        if (!$ceo || $ceo['role'] !== 'ceo') {
            flash('error', 'CEO no encontrado.');
            redirect_to('admin');
        }

        if (!(int) ($ceo['is_approved'] ?? 1) === 0) {
            flash('error', 'Este CEO ya fue procesado.');
            redirect_to('admin');
        }

        User::rejectCEO($id);
        $mailSent = send_app_mail($ceo['email'], 'Solicitud de CEO Rechazada', "Hola {$ceo['name']}, lamentablemente tu solicitud para ser CEO ha sido rechazada.");
        flash('ok', 'CEO rechazado y su solicitud eliminada.');
        redirect_to('admin');
    }

    public static function createAirline(): void
    {
        require_role('admin');
        $name = clean_text($_POST['name'] ?? '');
        $code = strtoupper(clean_text($_POST['code'] ?? ''));
        $country = clean_text($_POST['country'] ?? '');

        $errors = [];
        if ($name === '') {
            $errors['name'] = 'Campo obligatorio.';
        }
        if ($code === '') {
            $errors['code'] = 'Campo obligatorio.';
        }
        if ($country === '') {
            $errors['country'] = 'Campo obligatorio.';
        } elseif (preg_match('/\d/', $country)) {
            $errors['country'] = 'El país no puede contener números.';
        }

        if (!empty($errors)) {
            $_SESSION['airline_create_errors'] = $errors;
            $_SESSION['airline_create_old'] = [
                'name' => $name,
                'code' => $code,
                'country' => $country,
            ];
            redirect_to('admin');
        }

        unset($_SESSION['airline_create_errors'], $_SESSION['airline_create_old']);

        Airline::create($name, $code, $country);
        flash('ok', 'Aerolinea creada.');
        redirect_to('admin');
    }

    public static function createCeo(): void
    {
        require_role('admin');

        $name = clean_text($_POST['name'] ?? '');
        $email = clean_email($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $airlineId = int_value($_POST['airline_id'] ?? 0);

        if ($name === '' || $email === '' || $password === '' || $airlineId < 1) {
            flash('error', 'Completa todos los campos para crear el CEO.');
            redirect_to('admin');
        }

        if (!valid_email($email)) {
            flash('error', 'Email invalido.');
            redirect_to('admin');
        }

        if (!Airline::findById($airlineId)) {
            flash('error', 'Aerolinea invalida.');
            redirect_to('admin');
        }

        if (User::findByEmail($email)) {
            flash('error', 'Ya existe un usuario con ese email.');
            redirect_to('admin');
        }

        if (User::findByAirlineAndRole($airlineId, 'ceo')) {
            flash('error', 'Esa aerolinea ya tiene un CEO asignado.');
            redirect_to('admin');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        User::create($name, $email, '', '', '', $hash, 'ceo', $airlineId);
        flash('ok', 'CEO creado correctamente.');
        redirect_to('admin');
    }

    public static function updateAirline(): void
    {
        require_role('admin');
        $id = int_value($_POST['airline_id'] ?? 0);
        $name = clean_text($_POST['name'] ?? '');
        $code = strtoupper(clean_text($_POST['code'] ?? ''));
        $country = clean_text($_POST['country'] ?? '');

        $errors = [];
        if ($name === '') {
            $errors['name'] = 'Campo obligatorio.';
        }
        if ($code === '') {
            $errors['code'] = 'Campo obligatorio.';
        }
        if ($country === '') {
            $errors['country'] = 'Campo obligatorio.';
        } elseif (preg_match('/\d/', $country)) {
            $errors['country'] = 'El país no puede contener números.';
        }

        if ($id < 1 || !empty($errors)) {
            $_SESSION['airline_update_errors'][(int) $id] = $errors;
            $_SESSION['airline_update_old'][(int) $id] = [
                'name' => $name,
                'code' => $code,
                'country' => $country,
            ];
            redirect_to('admin');
        }

        unset($_SESSION['airline_update_errors'][(int) $id], $_SESSION['airline_update_old'][(int) $id]);

        Airline::update($id, $name, $code, $country);
        flash('ok', 'Aerolinea actualizada.');
        redirect_to('admin');
    }

    public static function deleteAirline(): void
    {
        require_role('admin');
        $id = int_value($_POST['airline_id'] ?? 0);
        if ($id > 0) {
            Airline::delete($id);
            flash('ok', 'Aerolinea eliminada.');
        }
        redirect_to('admin');
    }

    public static function approvePromotion(): void
    {
        require_role('admin');
        $id = int_value($_POST['promotion_id'] ?? 0);
        if ($id > 0) {
            Promotion::setStatus($id, 'approved');
            flash('ok', 'Promocion aprobada.');
        }
        redirect_to('admin');
    }

    public static function denyPromotion(): void
    {
        require_role('admin');
        $id = int_value($_POST['promotion_id'] ?? 0);
        if ($id > 0) {
            Promotion::setStatus($id, 'denied');
            flash('ok', 'Promocion denegada.');
        }
        redirect_to('admin');
    }

    public static function createNews(): void
    {
        require_role('admin');

        $title = clean_text($_POST['title'] ?? '');
        $content = clean_text($_POST['content'] ?? '');

        // Dejamos las fechas como string vacío si no fueron ingresadas
        $startDate = trim((string) ($_POST['start_date'] ?? ''));
        $endDate = trim((string) ($_POST['end_date'] ?? ''));

        $errors = [];

        // Titulo
        if ($title === '') {
            $errors['title'] = 'El campo es obligatorio.';
        } elseif (!preg_match('/\p{L}/u', $title)) {
            $errors['title'] = 'Título inválido.';
        }

        // Contenido
        if ($content === '') {
            $errors['content'] = 'El campo es obligatorio.';
        } elseif (!preg_match('/\p{L}/u', $content)) {
            $errors['content'] = 'Contenido inválido.';
        }

        // Fecha de inicio
        if ($startDate === '') {
            $errors['start_date'] = 'El campo es obligatorio.';
        } elseif (!valid_news_date($startDate)) {
            $errors['start_date'] = 'La fecha de inicio no es válida.';
        }

        // Fecha de fin
        if ($endDate === '') {
            $errors['end_date'] = 'El campo es obligatorio.';
        } elseif (!valid_news_date($endDate)) {
            $errors['end_date'] = 'La fecha de fin no es válida.';
        }

        // Validacion de fechas
        if (
            !isset($errors['start_date']) &&
            !isset($errors['end_date']) &&
            $endDate < $startDate
        ) {
            $errors['end_date'] = 'La fecha de fin no puede ser anterior a la fecha de inicio.';
        }

        if (!empty($errors)) {
            flash('error', 'Revisa los campos marcados para continuar.');
            self::panel($errors, [
                'title' => $title,
                'content' => $content,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
            exit;
        }

        //Crear novedad
        News::create(
            $title,
            $content,
            $startDate,
            $endDate
        );

        unset(
            $_SESSION['create_news_errors'],
            $_SESSION['create_news_old']
        );
        $GLOBALS['create_news_errors'] = [];
        $GLOBALS['create_news_old_values'] = [];

        flash('ok', 'Novedad publicada.');

        redirect_to('admin');
    }

    public static function updateNews(): void
    {
        require_role('admin');
        $id = int_value($_POST['news_id'] ?? 0);
        $title = clean_text($_POST['title'] ?? '');
        $content = clean_text($_POST['content'] ?? '');
        $startDate = trim((string) ($_POST['start_date'] ?? '')) ?: null;
        $endDate = trim((string) ($_POST['end_date'] ?? '')) ?: null;

        $errors = [];

        if ($id < 1) {
            $errors['id'] = 'Novedad inválida.';
        }

        if ($title === '') {
            $errors['title'] = 'El campo es obligatorio.';
        } elseif (!preg_match('/\p{L}/u', $title)) {
            $errors['title'] = 'Título inválido.';
        }

        if ($content === '') {
            $errors['content'] = 'El campo es obligatorio.';
        } elseif (!preg_match('/\p{L}/u', $content)) {
            $errors['content'] = 'Contenido inválido.';
        }

        if ($startDate === null || $startDate === '') {
            $errors['start_date'] = 'El campo es obligatorio.';
        } elseif (!valid_news_date($startDate)) {
            $errors['start_date'] = 'La fecha de inicio no es válida.';
        }

        if ($endDate === null || $endDate === '') {
            $errors['end_date'] = 'El campo es obligatorio.';
        } elseif (!valid_news_date($endDate)) {
            $errors['end_date'] = 'La fecha de fin no es válida.';
        }

        if (
            !isset($errors['start_date']) &&
            !isset($errors['end_date']) &&
            $endDate < $startDate
        ) {
            $errors['end_date'] = 'La fecha de fin no puede ser anterior a la fecha de inicio.';
        }

        if (!empty($errors)) {
            flash('error', 'Revisa los campos marcados para continuar.');
            redirect_to('admin');
        }

        News::update($id, $title, $content, $startDate, $endDate);
        flash('ok', 'Novedad actualizada.');
        redirect_to('admin');
    }

    public static function deleteNews(): void
    {
        require_role('admin');
        $id = int_value($_POST['news_id'] ?? 0);
        if ($id > 0) {
            News::delete($id);
            flash('ok', 'Novedad eliminada.');
        }
        redirect_to('admin');
    }
}
