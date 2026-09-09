<?php

use App\Controller\SalleController;
use FastRoute\RouteCollector;

return static function (array $controllers): void {
    $dispatcher = FastRoute\simpleDispatcher(
        require __DIR__ . '/web.php'
    );

    $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
    $salleController = $controllers[SalleController::class];

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
};
