<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 03.11.16
 * Time: 17:15
 */

require_once 'vendor/autoload.php';
require_once 'src/Config/config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

$connector = new Repositories\Connector(
    $configuration['database'],
    $configuration['user'],
    $configuration['password']
);

$request = Request::createFromGlobals();

$routes = include __DIR__ . '/src/routing.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();

    $controllerName = 'Controllers\\' .$controller;
    $controller = new $controllerName($connector);

    $actionName = $action;
    if (isset($id)) {
        $response = $controller->$actionName($id);
    } else {
        $response = $controller->$actionName();
    }
    echo $response;
} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
} catch (Exception $e) {
    $response = new Response('An error occurred', 500);
}

$response->send();
