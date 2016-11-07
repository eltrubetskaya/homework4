<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 03.11.16
 * Time: 17:15
 */

require_once 'vendor/autoload.php';
require_once 'src/Config/config.php';

$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'data';
$controllerName = ucfirst($controllerName) . 'Controller';
$controllerName = 'Controllers\\' . $controllerName;

$connector = new Repositories\Connector(
    $configuration['database'],
    $configuration['user'],
    $configuration['password']
);
$controller = new $controllerName($connector);

$actionName = isset($_GET['action']) ? $_GET['action'] : 'create';
$actionName = $actionName . 'Action';

$response = $controller->$actionName();

echo $response;
