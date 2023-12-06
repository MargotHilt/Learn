<?php

use GuzzleHttp\Psr7\ServerRequest;
use Simovative\Kaboom\App\ApplicationFactory;

require '../vendor/autoload.php';

session_start();

/*if (isset($_SESSION['userId']) && is_numeric($_SESSION['userId']) > 0){
    header('Location: /dashboard');
    exit();
}*/

$request = ServerRequest::fromGlobals();

$applicationFactory = new ApplicationFactory();
$path = $request->getUri()->getPath();

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
}
