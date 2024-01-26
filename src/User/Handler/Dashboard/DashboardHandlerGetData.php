<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Dashboard;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\Session\SessionInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class DashboardHandlerGetData implements RequestHandlerInterface
{
    public function __construct(
        private SessionInterface $session,
        private Environment $renderer,
        private UserRepositoryInterface $query
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->session->setSessionValue('userId') ?? 0;
        $userName = $this->session->setSessionValue('userName') ?? 'User';
        $userPic = $this->session->setSessionValue('userPic') ?? '';

        if ($userId === 0) {
            return new Response(302, ['Location' => '/']);
        }

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

        $this->query->select(
            'post',
            [   'post.id',
                'title',
                'post_text',
                'first_name',
                'last_name',
                'profile_pic',
                'user_id',
                'likes',
                'date',
                'is_edited'
            ]
        )
            ->leftJoin('`user`', '`id`', '`post`', '`user_id`')
            ->prepBindExec();
        $postData = $this->query->fetchAll();

        $this->query->select('post_liked', ['post_id'])
            ->where('user_id', '=', ':userId')
            ->prepBindExec(['userId' => $userId]);
        $userLikedPost = $this->query->fetchAll();

        $likedPost = [];
        foreach ($userLikedPost as $post){
            $likedPost[] = $post['post_id'];
        }

        return new Response(200, [], $this->renderer->render('dashboard.twig', [
            'weather' => $weather,
            'description' => $description,
            'temperature' => $temperature,
            'precipProb' => $precipProb,
            'location' => $location,
            'userId' => $userId,
            'postData' => $postData,
            'userLikedPost' => $likedPost,
            'userName' => $userName,
            'userPic' => $userPic
        ]));

    }
}