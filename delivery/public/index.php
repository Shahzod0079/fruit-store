<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$route = $_GET['route'] ?? 'auth/login';
$parts = explode('/', $route);
$controller = $parts[0];
$action = $parts[1] ?? 'login';

$controllerFile = __DIR__ . '/../controllers/' . ucfirst($controller) . 'Controller.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $class = ucfirst($controller) . 'Controller';
    $obj = new $class($pdo);
    $obj->$action();
} else {
    die("Контроллер не найден");
}