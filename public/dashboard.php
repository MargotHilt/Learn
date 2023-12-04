<?php
require '../vendor/autoload.php';

session_start();

// post stuff

$userId = $_SESSION['userId'] ?? 0;

if($userId != 0) {

    $serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

    $applicationFactory = new \Simovative\Kaboom\App\ApplicationFactory();

    $applicationFactory->createUserFactory()
        ->createDashboardPostHandler()
        ->handle($serverRequest);

    $applicationFactory->createUserFactory()
        ->createDashboardDeleteHandler()
        ->handle($serverRequest);

    echo $applicationFactory->createUserFactory()
        ->createDashboardGetDataHandler()
        ->handle($serverRequest)
        ->getBody();

} else {
    header('Location: login.php');
}


