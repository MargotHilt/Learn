<?php

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$pdo = new PDO('mysql:host=mysql_db;dbname=kaboom', 'root', 'root');
#username and password from db in pdo method.

$sql = 'INSERT INTO 
            user (email, password, first_name, last_name) 
        VALUES 
            (:email, :password, :first_name, :last_name)';

$statement = $pdo->prepare($sql);

$statement->bindParam(':email', $email);
$statement->bindParam(':password', $password);
$statement->bindParam(':first_name', $firstName);
$statement->bindParam(':last_name', $lastName);

$statement->execute();

$userId = $pdo->lastInsertId();
var_dump($userId);