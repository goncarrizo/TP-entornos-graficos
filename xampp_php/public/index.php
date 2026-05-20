<?php

require __DIR__ . '/../app/bootstrap.php';

$page = $_GET['page'] ?? 'home';
$action = $_POST['action'] ?? null;

if ($action) {
    try {
        switch ($action) {
            case 'register':
                AuthController::register();
                break;
            case 'login':
                AuthController::login();
                break;
            case 'logout':
                AuthController::logout();
                break;
            case 'update_profile':
                AuthController::updateProfile();
                break;
            case 'change_password':
                AuthController::changePassword();
                break;
            case 'contact_submit':
                SiteController::contactSubmit();
                break;
            case 'reserve':
                ReservationController::reserve();
                break;
            case 'toggle_favorite':
                FlightController::toggleFavorite();
                break;
            case 'cancel_reservation':
                ReservationController::cancel();
                break;
            case 'create_flight':
                FlightController::create();
                break;
            case 'update_flight':
                FlightController::update();
                break;
            case 'delete_flight':
                FlightController::delete();
                break;
            case 'create_promotion':
                CeoController::createPromotion();
                break;
            case 'update_promotion':
                CeoController::updatePromotion();
                break;
            case 'delete_promotion':
                CeoController::deletePromotion();
                break;
            case 'create_airline':
                AdminController::createAirline();
                break;
            case 'create_airline_request':
                CeoController::createAirlineRequest();
                break;
            case 'update_airline':
                AdminController::updateAirline();
                break;
            case 'delete_airline':
                AdminController::deleteAirline();
                break;
            case 'approve_promotion':
                AdminController::approvePromotion();
                break;
            case 'deny_promotion':
                AdminController::denyPromotion();
                break;
            case 'approve_airline_request':
                AdminController::approveAirlineRequest();
                break;
            case 'deny_airline_request':
                AdminController::denyAirlineRequest();
                break;
            case 'approve_flight_request':
                AdminController::approveFlightRequest();
                break;
            case 'deny_flight_request':
                AdminController::denyFlightRequest();
                break;
            case 'approve_reservation':
                CeoController::approveReservation();
                break;
            case 'deny_reservation':
                CeoController::denyReservation();
                break;
            case 'create_news':
                AdminController::createNews();
                break;
            case 'update_news':
                AdminController::updateNews();
                break;
            case 'delete_news':
                AdminController::deleteNews();
                break;
            case 'export_sales_csv_admin':
                AdminController::exportSalesCsv();
                break;
            case 'export_sales_csv_ceo':
                CeoController::exportSalesCsv();
                break;
            case 'export_occupancy_csv_ceo':
                CeoController::exportOccupancyCsv();
                break;
            default:
                flash('error', 'Accion no reconocida.');
                redirect_to('home');
        }
    } catch (Throwable $error) {
        flash('error', 'Ocurrio un error: ' . $error->getMessage());
        redirect_to($page);
    }
}

switch ($page) {
    case 'home':
        $homeUser = is_logged_in() ? current_user() : null;
        $favoriteFlights = [];
        $recentReservations = [];

        if ($homeUser) {
            $favoriteFlights = Favorite::flightsByUser((int) $homeUser['id'], 3);
            $recentReservations = array_slice(Reservation::byUser((int) $homeUser['id']), 0, 3);
        }

        view('home', [
            'user' => $homeUser,
            'airlines' => Airline::all(),
            'news' => News::all(),
            'favorite_flights' => $favoriteFlights,
            'recent_reservations' => $recentReservations,
        ]);
        break;
    case 'login':
        view('login');
        break;
    case 'register':
        view('register');
        break;
    case 'profile':
        require_login();
        $profileUser = current_user();
        $profileReservations = Reservation::byUser((int) $profileUser['id']);
        $profileSummary = [
            'total' => count($profileReservations),
            'confirmed' => 0,
            'cancelled' => 0,
            'total_spent' => 0.0,
        ];

        foreach ($profileReservations as $reservationItem) {
            if (($reservationItem['status'] ?? '') === 'cancelled') {
                $profileSummary['cancelled']++;
                continue;
            }

            $profileSummary['confirmed']++;
            $profileSummary['total_spent'] += (float) ($reservationItem['total_amount'] ?? 0);
        }

        view('profile', [
            'user' => $profileUser,
            'summary' => $profileSummary,
            'recent_reservations' => array_slice($profileReservations, 0, 5),
        ]);
        break;
    case 'account_edit':
        require_login();
        view('account_edit', ['user' => current_user()]);
        break;
    case 'flights':
        FlightController::listPage();
        break;
    case 'faq':
        view('faq');
        break;
    case 'contact':
        view('contact');
        break;
    case 'system_status':
        SiteController::systemStatusPage();
        break;
    case 'reservations':
        ReservationController::listPage();
        break;
    case 'news':
        $newsPage = max(1, (int) ($_GET['p'] ?? 1));
        $perPage = 5;
        $total = News::countAll();
        $pager = paginate($total, $perPage, $newsPage);
        $news = News::paginated($pager['limit'], $pager['offset']);
        view('news', ['news' => $news, 'pager' => $pager]);
        break;
    case 'admin':
        AdminController::panel();
        break;
    case 'ceo':
        CeoController::panel();
        break;
    default:
        http_response_code(404);
        view('notfound');
        break;
}
