<?php

declare(strict_types=1);

use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Validator\SalleValidator;
use App\Validator\ReservationValidator;
use App\Validator\ValidatorFactory;
use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use Illuminate\Database\Capsule\Manager;
use function DI\autowire;
use function DI\factory;

$root = dirname(__DIR__);
Dotenv::createImmutable($root)->safeLoad();

return [
    SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
    ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),
    ValidatorFactory::class => factory(static function (): ValidatorFactory {
        return new ValidatorFactory([
            new SalleValidator(),
            new ReservationValidator(),
        ]);
    }),
    SalleValidator::class => factory(
        static fn (ValidatorFactory $factory): SalleValidator => $factory->getValidator('salle')
    ),
    ReservationValidator::class => factory(
        static fn (ValidatorFactory $factory): ReservationValidator => $factory->getValidator('reservation')
    ),
    Manager::class => factory(static function (): Manager {
        $configureDatabase = require dirname(__DIR__) . '/config/database.php';

        return $configureDatabase;
    }),
    Dispatcher::class => factory(static function (): Dispatcher {
        return FastRoute\simpleDispatcher(require dirname(__DIR__) . '/routes/web.php');
    }),
];