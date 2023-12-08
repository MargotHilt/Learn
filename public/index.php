<?php

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\ApplicationFactory;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require '../vendor/autoload.php';

/*if (isset($_SESSION['userId']) && is_numeric($_SESSION['userId']) > 0){
    header('Location: /dashboard');
    exit();
}*/

$request = ServerRequest::fromGlobals();
$applicationFactory = new ApplicationFactory();

$routes = require __DIR__.'/../config/routes.php';

$matcher = new UrlMatcher($routes, new RequestContext());
try {
    $parameters = $matcher->match($request->getUri()->getPath());
    $handler = ($parameters['handler'])($applicationFactory);

    if ($handler instanceof RequestHandlerInterface) {
        $response = $handler->handle($request);
        $applicationFactory->emitter()->emit($response);
    }
    //echo $parameters['id'] ?? 'no id';
} catch(ResourceNotFoundException) {
    echo '404 not found';
}

/*$path = $request->getUri()->getPath();
if ($path === '/') {
    $response = $applicationFactory->createUserFactory()
        ->createLoginGetHandler()
        ->handle($request);

} elseif ($path === '/login') {
    $response = $applicationFactory->createUserFactory()
        ->createLoginGetHandler()
        ->handle($request);

} elseif ($path === '/logout') {

    unset($_SESSION['userId']);
    header('Location: /');

} elseif ($path === '/register'){

    $response = $applicationFactory->createUserFactory()
        ->createRegisterGetHandler()
        ->handle($request);

} elseif ($path === '/dashboard') {

    $userId = $_SESSION['userId'] ?? 0;

    if($userId != 0) {

        $response = $applicationFactory->createUserFactory()
            ->createDashboardGetDataHandler()
            ->handle($request);

    } else {
        header('Location: /');
    }

} elseif ($path === '/dashboard/post/update') {

    $response = $applicationFactory->createUserFactory()
        ->createDashboardUpdateHandler()
        ->handle($request);

} elseif ($path === '/dashboard/post/delete') {

    $response = $applicationFactory->createUserFactory()
        ->createDashboardDeleteHandler()
        ->handle($request);

} elseif ($path === '/dashboard/post/post') {

    $response = $applicationFactory->createUserFactory()
        ->createDashboardPostHandler()
        ->handle($request);
}

if(isset($response)) {
    $applicationFactory->emitter()->emit($response);
}*/