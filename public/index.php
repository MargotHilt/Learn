<?php

require '../vendor/autoload.php';


session_start();
if (isset($_SESSION['userId']) && is_numeric($_SESSION['userId']) > 0){
    header('Location: dashboard.php');
    exit();
}

$loader = new \Twig\Loader\FilesystemLoader('../src/User/Templates');
$twig = new \Twig\Environment($loader, [
        'cache' => false,
]);

echo $twig->render('index.twig', ['name' => 'Margot']);