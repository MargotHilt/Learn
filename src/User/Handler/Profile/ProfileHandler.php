<?php

namespace Simovative\Kaboom\User\Handler\Profile;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\Session\SessionInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class ProfileHandler implements RequestHandlerInterface
{

    public function __construct(
        private readonly SessionInterface $session,
        private readonly Environment $renderer,
        private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->session->setSessionValue('userId') ?? 0;
        $userName = $this->session->setSessionValue('userName') ?? 'User';
        $userLastName = $this->session->setSessionValue('userLastName') ?? 'User';
        $userPic = $this->session->setSessionValue('userPic') ?? '';

        if ($userId === 0) {
            return new Response(302, ['Location' => '/']);
        }

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
                'date'
            ]
        )
            ->leftJoin('`user`', '`id`', '`post`', '`user_id`')
            ->where('user_id', '=', ':userId')
            ->prepBindExec(['userId' => $userId]);
        $postData = $this->query->fetchAll();

        $this->query->select('post_liked', ['post_id'])
            ->where('user_id', '=', ':userId')
            ->prepBindExec(['userId' => $userId]);
        $userLikedPost = $this->query->fetchAll();

        $likedPost = [];
        foreach ($userLikedPost as $post){
            $likedPost[] = $post['post_id'];
        }

        return new Response(200, [], $this->renderer->render('profile.twig', [
            'userId' => $userId,
            'postData' => $postData,
            'userLikedPost' => $likedPost,
            'userName' => $userName,
            'userLastName' => $userLastName,
            'userPic' => $userPic
        ]));
    }

}