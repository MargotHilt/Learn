<?php
require '../vendor/autoload.php';

session_start();

$pdo = new PDO('mysql:host=mysql_db;dbname=kaboom', 'root', 'root');

if(isset($_POST['delete'])) {

    $postId = MyHandler::handleServerRequest('post', 'delete');

    $sql = 'DELETE FROM `post`
            WHERE `id` = :post_id';


    $statement = $pdo->prepare($sql);
    $statement->bindParam(':post_id', $postId);
    $statement->execute();
}

if(isset($_POST['openEditField'])) {

    //edit field reopens in html
    //select title and text to put into html template
    // if stmt in the html toggle editing field or comment field

}


    header('Location: dashboard.php');