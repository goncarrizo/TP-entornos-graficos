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
            case 'reserve':
                ReservationController::reserve();
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
            case 'create_news':
                AdminController::createNews();
                break;
            case 'update_news':
                AdminController::updateNews();
                break;
            case 'delete_news':
                AdminController::deleteNews();
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
        view('home', [
            'airlines' => Airline::all(),
            'news' => News::all(),
        ]);
        break;
    case 'login':
        view('login');
        break;
    case 'profile':
        require_login();
        view('profile', ['user' => current_user()]);
        break;
    case 'flights':
        FlightController::listPage();
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
