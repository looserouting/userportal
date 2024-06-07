<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = rawurldecode($_SERVER['REQUEST_URI']);


$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/php-di.conf.php');
$containerBuilder->useAttributes(true);
$container = $containerBuilder->build();

// check authentication. If not authenticated redirect to /login
// TODO Controle Session Timeout(set and check timeout)
if ($uri != '/login') {
    if (!isset($_SESSION['sessionuser']) || $_SESSION['sessionuser']['auth'] < 1) {
        if (preg_match($uri,"/^\/api/")) {
            header('Content-Type: application/json');
            echo json_encode(['response' => 403, 'message' => 'Fobidden']);
        } else {
            header('Location: /login', true, 302);
        }
        exit();
    }
}

// Register Routes
// TODO CachedDispatcher
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute(['GET','POST'], '/login[?dst={referer}]', ['App\Controller\LoginController', 'login']);
    $r->addRoute('GET', '/', ['App\Controller\DashboardController','show']);
    $r->addRoute('GET', '/products', ['App\Controller\ProductsController','list']);
    $r->addRoute(['POST'], '/logout', ['App\Controller\LoginController', 'logout']);
    $r->addRoute(['GET'], '/customers', ['App\Controller\CustomersController', 'list']);
    $r->addRoute(['GET'], '/invoicing', ['App\Controller\InvoicingController', 'show']);
    $r->addRoute(['GET'], '/orders', ['App\Controller\OrdersController', 'list']);
    $r->addRoute(['GET'], '/pbx', ['App\Controller\PBXController', 'show']);
    $r->addRoute(['GET'], '/users', ['App\Controller\UsersController', 'list']);
    $r->addRoute(['GET'], '/tickets', ['App\Controller\TicketsController', 'list']);

    $r->addGroup('/products', function (FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/add', ['App\Controller\ProductsController','add']);
        $r->addRoute('GET', '/delete/{id:\d+}', ['App\Controller\ProductsController','delete']);
        $r->addRoute('GET', '/modify/{id:\d+}', ['App\Controller\ProductsController','modify']);
        $r->addRoute('GET', '/show/{id:\d+}', ['App\Controller\ProductsController','show']);
    });

    $r->addGroup('/users', function (FastRoute\RouteCollector $r) {
        $r->addRoute(['GET','POST'], '/add', ['App\Controller\UsersController','add']);
    });

    $r->addGroup('/api', function (FastRoute\RouteCollector $r) {
        $r->addRoute(['GET','POST'], '/users', ['App\Controller\UsersController','fetch']);
    });

});

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed" . PHP_EOL;
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $routeInfo[1];
        $parameters = $routeInfo[2];

        $container->call($controller, $parameters);

        break;
}
