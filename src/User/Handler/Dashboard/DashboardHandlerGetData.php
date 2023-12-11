<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Dashboard;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepository;
use Twig\Environment;

class DashboardHandlerGetData implements RequestHandlerInterface
{
    public function __construct(private readonly PDO $pdo, private Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $userId = $_SESSION['userId'] ?? 0;

        if($userId != 0) {
            $url = 'https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Munich?&unitGroup=metric&key=2UXEELM3P6G2TGFPDU7KW6PUV&contentType=json';

            $client = new Client();

            $res = $client->get($url);
            $res = $res->getBody();
            $json = json_decode((string)$res, true);

            $location = $json['address'];
            $description = $json['days'][0]['description'];
            $temperature = $json['days'][0]['temp'];
            $precipProb = $json['days'][0]['precipprob'];
            $weather = $json['days'][0]['icon'];

            $userId = $_SESSION['userId'] ?? 0;

            $query = new UserRepository();
            $query->select(
                'post',
                [   'post.id',
                    'title',
                    'post_text',
                    'first_name',
                    'last_name',
                    'profile_pic',
                    'user_id'
                ]
            )
                ->leftJoin('`user`', '`id`', '`post`', '`user_id`')
                ->prepBindExec();
            $postData = $query->fetchAll();

            return new Response(200, [], $this->renderer->render('dashboard.twig', [
                'weather' => $weather,
                'description' => $description,
                'temperature' => $temperature,
                'precipProb' => $precipProb,
                'location' => $location,
                'userId' => $userId,
                'postData' => $postData
            ]));
        } else {
            return new Response(200, ['Location' => '/']);
        }
    }

}