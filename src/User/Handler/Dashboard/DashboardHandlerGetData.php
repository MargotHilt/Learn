<?php

namespace Simovative\Kaboom\User\Handler\Dashboard;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

class DashboardHandlerGetData implements RequestHandlerInterface
{
    public function __construct(private PDO $pdo, private Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $url = 'https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Munich?&unitGroup=metric&key=2UXEELM3P6G2TGFPDU7KW6PUV&contentType=json';

        $client = new \GuzzleHttp\Client();

        $res = $client->get($url);
        $res = $res->getBody();
        $json = json_decode($res, true);

        $location = $json['address'];
        $description = $json['days'][0]['description'];
        $temperature = $json['days'][0]['temp'];
        $precipProb = $json['days'][0]['precipprob'];
        $weather = $json['days'][0]['icon'];

        $userId = $_SESSION['userId'] ?? 0;
        $sqlRequest = '
        SELECT 
            `post`.`id`,
            `title`,
            `post_text`,
            `first_name`,
            `last_name`,
            `user_id`
        FROM `post`
        LEFT JOIN `user` 
        ON `user`.`id` = `post`.`user_id`';

        $stmt = $this->pdo->prepare($sqlRequest);
        $stmt->execute();
        $postData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return new \GuzzleHttp\Psr7\Response(200, [], $this->renderer->render('dashboard.twig', [
            'weather' => $weather,
            'description' => $description,
            'temperature' => $temperature,
            'precipProb' => $precipProb,
            'location' => $location,
            'userId' => $userId,
            'postData' => $postData]));
    }

}