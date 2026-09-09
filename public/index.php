<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

require_once dirname(__DIR__) . '/config/database.php';

use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use App\Services\AnnulerReservationService;
use App\Services\CreerReservationService;
use App\Validator\ReservationValidator;
use App\Validator\SalleValidator;

$salles = new EloquentSalleRepository();
$reservations = new EloquentReservationRepository();

$salleController = new SalleController($salles, new SalleValidator());
$reservationController = new ReservationController(
    $reservations,
    $salles,
    new ReservationValidator(),
    new CreerReservationService($salles, $reservations),
    new AnnulerReservationService($reservations),
);

$controllers = [
    SalleController::class => $salleController,
    ReservationController::class => $reservationController,
];

(require dirname(__DIR__) . '/routes/router.php')($controllers);
