<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = rawurldecode($_SERVER['REQUEST_URI']);

// check authentication. If not authenticated redirect to /login
// TODO Controll Session Timeout(set and check timeout)
if ($uri != '/login') {
    if ( !isset($_SESSION['user']) || $_SESSION['user']['auth'] < 1 ) {
        header('Location: /login', true, 302);
        exit();
    }
}

// Register Routes
// TODO CachedDispatcher
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute(['GET','POST'], '/login[?dst={referer}]', ['App\Controller\LoginController', 'login']);

    $r->addGroup('/products', function(FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/', ['App\Controller\ProductsController','list']);
        $r->addRoute('GET', '/add', ['App\Controller\ProductsController','add']);
        $r->addRoute('GET', '/delete/{id:\d+}', ['App\Controller\ProductsController','delete']);
        $r->addRoute('GET', '/modify/{id:\d+}', ['App\Controller\ProductsController','modify']);
        $r->addRoute('GET', '/show/{id:\d+}', ['App\Controller\ProductsController','show']);
    });
});

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/php-di.conf.php');
//$containerBuilder->useAnnotations(true);
$containerBuilder->useAttributes(true);
$container = $containerBuilder->build();

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed" . PHP_EOL;
        print_r($routeInfo[1]) ;
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $routeInfo[1];
        $parameters = $routeInfo[2];

        $container->call($controller, $parameters);
        break;
}

echo "URI :" . $uri . "</br>";
echo "</br>";

echo "Route Info</br>";
echo nl2br(print_r($routeInfo, true));
echo "</br>";

echo "SESSION</br>";
echo nl2br(print_r($_SESSION));
echo "</br>";

echo "POST:</br>";
print_r($_POST);
echo "</br>";

echo "GET:</br>";
print_r($_GET);
echo "</br>";
?>
