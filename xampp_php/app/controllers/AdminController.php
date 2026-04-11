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

    public static function panel(): void
    {
        require_role('admin');

        $airlines = Airline::all();
        $promotions = Promotion::all();
        $news = News::all();
        $reports = Report::general();
        $sales = Report::salesByAirline();

        view('admin', compact('airlines', 'promotions', 'news', 'reports', 'sales'));
    }

    public static function createAirline(): void
    {
        require_role('admin');
        $name = clean_text($_POST['name'] ?? '');
        $code = strtoupper(clean_text($_POST['code'] ?? ''));
        $country = clean_text($_POST['country'] ?? '');

        if ($name === '' || $code === '' || $country === '') {
            flash('error', 'Completa todos los campos de aerolinea.');
            redirect_to('admin');
        }

        Airline::create($name, $code, $country);
        flash('ok', 'Aerolinea creada.');
        redirect_to('admin');
    }

    public static function updateAirline(): void
    {
        require_role('admin');
        $id = int_value($_POST['airline_id'] ?? 0);
        $name = clean_text($_POST['name'] ?? '');
        $code = strtoupper(clean_text($_POST['code'] ?? ''));
        $country = clean_text($_POST['country'] ?? '');

        if ($id < 1 || $name === '' || $code === '' || $country === '') {
            flash('error', 'Datos invalidos para actualizar aerolinea.');
            redirect_to('admin');
        }

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

        if ($title === '' || $content === '') {
            flash('error', 'Completa titulo y contenido.');
            redirect_to('admin');
        }

        News::create($title, $content);
        flash('ok', 'Novedad publicada.');
        redirect_to('admin');
    }

    public static function updateNews(): void
    {
        require_role('admin');
        $id = int_value($_POST['news_id'] ?? 0);
        $title = clean_text($_POST['title'] ?? '');
        $content = clean_text($_POST['content'] ?? '');

        if ($id < 1 || $title === '' || $content === '') {
            flash('error', 'Datos invalidos para actualizar novedad.');
            redirect_to('admin');
        }

        News::update($id, $title, $content);
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
