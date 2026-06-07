<?php

require __DIR__ . '/config/config.php';
require __DIR__ . '/core/Database.php';
require __DIR__ . '/helpers/auth.php';
require __DIR__ . '/helpers/view.php';
require __DIR__ . '/helpers/validation.php';
require __DIR__ . '/helpers/mail.php';
require __DIR__ . '/helpers/csrf.php';

require __DIR__ . '/models/User.php';
require __DIR__ . '/models/Airline.php';
require __DIR__ . '/models/AirlineRequest.php';
require __DIR__ . '/models/FlightRequest.php';
require __DIR__ . '/models/Flight.php';
require __DIR__ . '/models/Promotion.php';
require __DIR__ . '/models/Reservation.php';
require __DIR__ . '/models/News.php';
require __DIR__ . '/models/Report.php';
require __DIR__ . '/models/Favorite.php';

require __DIR__ . '/controllers/AuthController.php';
require __DIR__ . '/controllers/FlightController.php';
require __DIR__ . '/controllers/ReservationController.php';
require __DIR__ . '/controllers/AdminController.php';
require __DIR__ . '/controllers/CeoController.php';
require __DIR__ . '/controllers/SiteController.php';
