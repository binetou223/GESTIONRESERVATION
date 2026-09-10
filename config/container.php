<?php

declare(strict_types=1);

use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Validator\SalleValidator;
use App\Validator\ReservationValidator;
use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use Illuminate\Database\Capsule\Manager;
use function DI\autowire;
use function DI\factory;
use function DI\get;

$root = dirname(__DIR__);
Dotenv::createImmutable($root)->safeLoad();

return [
    SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
    ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),
    SalleValidator::class => autowire(),
    ReservationValidator::class => autowire(),

    ReservationController::class => autowire()
        ->constructorParameter(
            'validatorReservation',
            get(ReservationValidator::class)
        ),

    SalleController::class => autowire()
        ->constructorParameter(
            'validator',
            get(SalleValidator::class)
        ),
    Manager::class => factory(static function (): Manager {
        $configureDatabase = require dirname(__DIR__) . '/config/database.php';

        return $configureDatabase;
    }),
    Dispatcher::class => factory(static function (): Dispatcher {
        return FastRoute\simpleDispatcher(require dirname(__DIR__) . '/routes/web.php');
    }),
];