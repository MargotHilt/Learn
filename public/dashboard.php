<?php
require '../vendor/autoload.php';
require './MyHandler.php';

session_start();

// api calls

$url = 'https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Munich?&unitGroup=metric&key=2UXEELM3P6G2TGFPDU7KW6PUV&contentType=json';

$client = new GuzzleHttp\Client();

$res = $client->get($url);
$res = $res->getBody();
$json = json_decode($res, true);

$location = $json['address'];
$description = $json['days'][0]['description'];
$temperature = $json['days'][0]['temp'];
$precipProb = $json['days'][0]['precipprob'];
$weather = $json['days'][0]['icon'];

// post stuff

$pdo = new PDO('mysql:host=mysql_db;dbname=kaboom', 'root', 'root');
#username and password from db in pdo method.

if (isset($_POST['title']) && isset($_POST['post_text'])) {

    $title = MyHandler::handleServerRequest('post', 'title');
    $postText = MyHandler::handleServerRequest('post', 'post_text');
    $userId = $_SESSION['userId'];

    $sql = 'INSERT INTO 
            post (title, post_text, user_id) 
        VALUES 
            (:title, :post_text, :user_id)';

    $statement = $pdo->prepare($sql);

    $statement->bindParam(':title', $title);
    $statement->bindParam(':post_text', $postText);
    $statement->bindParam(':user_id', $userId);

    $statement->execute();
}

$sqlRequest = '
    SELECT 
        `title`,
        `post_text`,
        `first_name`,
        `last_name`
    FROM `post`
    LEFT JOIN `user` 
    ON `user`.id = `post`.user_id';

$stmt = $pdo->prepare($sqlRequest);
$stmt->execute();
$postData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$loader = new \Twig\Loader\FilesystemLoader('../src/User/Templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);
echo $twig->render('dashboard.twig', ['weather' => $weather,
                                            'description' => $description,
                                            'temperature' => $temperature,
                                            'precipProb' => $precipProb,
                                            'location' => $location,
                                            'postData' => $postData]);