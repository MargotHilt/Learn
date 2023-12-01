<?php
require '../vendor/autoload.php';

session_start();
if (isset($_SESSION['userId']) && is_numeric($_SESSION['userId']) > 0){
    header('Location: dashboard.php');
    exit();
}

$pdo = new PDO('mysql:host=mysql_db;dbname=kaboom', 'root', 'root');

$loader = new \Twig\Loader\FilesystemLoader('../src/User/Templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

$handler = new \Simovative\Kaboom\User\Handler\Register\RegisterGetHandler($pdo, $twig);
$response = $handler->handle($serverRequest);
echo $response->getBody();