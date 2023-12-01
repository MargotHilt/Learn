<?php
require '../vendor/autoload.php';

session_start();

// post stuff

$userId = $_SESSION['userId'] ?? 0;

$pdo = new PDO('mysql:host=mysql_db;dbname=kaboom', 'root', 'root');

$loader = new \Twig\Loader\FilesystemLoader('../src/User/Templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

$handlerPost = new \Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerPost($pdo, $twig);
$response = $handlerPost->handle($serverRequest);
$handlerGetPost = new \Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerGetData($pdo, $twig);
$responseGetPost = $handlerGetPost->handle($serverRequest);

echo $responseGetPost->getBody();


