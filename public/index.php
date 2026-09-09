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

$dispatcher = FastRoute\simpleDispatcher(require dirname(__DIR__) . '/routes/web.php');
$controllers = [
    SalleController::class => $salleController,
    ReservationController::class => $reservationController,
];

$httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo $salleController->notFound();
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        header('Allow: ' . implode(', ', $routeInfo[1]));
        echo $salleController->methodNotAllowed();
        break;
    case FastRoute\Dispatcher::FOUND:
        [$controller, $method] = $routeInfo[1];
        $arguments = array_values($routeInfo[2]);
        $instance = $controllers[$controller];
        $reflection = new ReflectionMethod($instance, $method);

        if ($reflection->getNumberOfRequiredParameters() > count($arguments)) {
            $arguments[] = $_POST;
        }

        echo $instance->$method(...$arguments);
        break;
}
