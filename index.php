<?php
define('ROOT_PATH', dirname(__FILE__));

require ROOT_PATH . '/config/routes.php';

$requestedUrl = $_SERVER['REQUEST_URI'];

if (array_key_exists($requestedUrl, $routes)) {
    $parts = explode('@', $routes[$requestedUrl]);
    $controllerName = $parts[0];
    $methodName = $parts[1];

    require ROOT_PATH . "/controllers/$controllerName.php";
    $controller = new $controllerName();
    $controller->$methodName();
} else {
    // Tratar caso a rota não seja encontrada
    header("HTTP/1.0 404 Not Found");
    // Exibir página 404 ou similar
}