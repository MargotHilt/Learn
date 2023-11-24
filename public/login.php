<?php

$pdo = new PDO('mysql:host=mysql_db;dbname=kaboom', 'root', 'root');
$email = $_POST['email'];

$sql = '
    SELECT 
        `email`, 
        `password`,
        `id`
    FROM `user` 
    WHERE `email` = :email';

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

//FETCH_ASSOC makes the use of $userData['password'] instead of $userData[1] possible (line 21)

if ($stmt->rowCount() > 0 && password_verify($_POST['password'], $userData['password'])) {
    session_start();
    $_SESSION['userId'] = $userData['id'];
    header('Location: dashboard.php');
    echo 'session started';
} else {
    echo 'wrong password or username';
}

