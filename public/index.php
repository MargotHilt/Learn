<?php

require '../vendor/autoload.php';

session_start();

if (isset($_SESSION['userId']) && is_numeric($_SESSION['userId']) > 0){
    header('Location: /dashboard.php');
    exit();
}
$request = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

$applicationFactory = new \Simovative\Kaboom\App\ApplicationFactory();
$path = $request->getUri()->getPath();

if ($path === '/') {
    $response = $applicationFactory->createUserFactory()
        ->createLoginGetHandler()
        ->handle($request);

} else if ($path === '/login') {
    $response = $applicationFactory->createUserFactory()
        ->createLoginGetHandler()
        ->handle($request);

} else if ($path === '/logout') {
    unset($_SESSION['userId']);
    header('Location: /');

} else if ($path === '/dashboard') {

    $userId = $_SESSION['userId'] ?? 0;

    if($userId != 0) {

        $applicationFactory->createUserFactory()
            ->createDashboardPostHandler()
            ->handle($request);

        $response = $applicationFactory->createUserFactory()
            ->createDashboardGetDataHandler()
            ->handle($request);

    } else {
        header('Location: login.php');
    }
} else if ($path === '/dashboard/post/delete') {

    $response = $applicationFactory->createUserFactory()
        ->createDashboardDeleteHandler()
        ->handle($request);
}

if(isset($response)) {
    $applicationFactory->emitter()->emit($response);
}
