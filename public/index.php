<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/containerFactory.php';

use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Container\ContainerFactory;
use Illuminate\Database\Capsule\Manager;

$container = (new ContainerFactory())->create();
$container->get(Manager::class);

$controllers = [
    SalleController::class => $container->get(SalleController::class),
    ReservationController::class => $container->get(ReservationController::class),
];

(require dirname(__DIR__) . '/routes/router.php')($controllers);
