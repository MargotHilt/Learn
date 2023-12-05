<?php
require '../vendor/autoload.php';

session_start();
if (isset($_SESSION['userId']) && is_numeric($_SESSION['userId']) > 0){
    header('Location: /dashboard.php');
    exit();
}

$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

$applicationFactory = new \Simovative\Kaboom\App\ApplicationFactory();
echo $applicationFactory->createUserFactory()
    ->createRegisterGetHandler()
    ->handle($serverRequest)
    ->getBody();