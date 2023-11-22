<?php

$pdo = new PDO('mysql:host=mysql_db;dbname=kaboom', 'root', 'root');
$email = $_POST['email'];

$sql = 'SELECT `email`, `password` FROM `user` WHERE `email` = ' . "'" . $email ."'";
$pdo = $pdo->prepare($sql);
$pdo->execute();
$userData = $pdo->fetch();

if($pdo->rowCount() > 0 && password_verify($_POST['password'],  $userData[1] ))
{
    session_start();
    echo 'session started';
} else echo 'wrong password or username';

