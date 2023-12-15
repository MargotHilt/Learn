<?php

namespace Simovative\Kaboom\User\Handler\Dashboard;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class DashboardHandlerLike implements RequestHandlerInterface
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly Environment $renderer,
        private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $_SESSION['userId'] ?? 0;
        $parseBody = $request->getParsedBody();

        $parseBody = json_decode(file_get_contents('php://input'), true);
        $like =  $parseBody['likeCount'];
        $postId =  $parseBody['postId'];

        $this->query->select('post', ['likes'])
            ->where('id', '=', ':postId')
            ->prepBindExec(['postId' => $postId]);
        $totalLikeArr = $this->query->fetch();

        $totalLike = $totalLikeArr['likes'];
        $totalLike += $like;

        $this->query->update('post', ['likes' => 'likes'])
            ->where('id', '=', ':postId')
            ->prepBindExec(['likes'=> $totalLike, 'postId' => $postId]);

        //check if comment has been liked (useless I think)
        /*$this->query->select('post_liked', ['user_id', 'post_id'])
            ->where('user_id', '=', ':userId')
            ->andwhere('post_id', '=', ':postId')
            ->prepBindExec(['postId' => $postId, 'userId' => $userId]);
        $isLiked = $this->query->fetch();*/

    if($like === 1) {
        $this->query->insert('post_liked', ['user_id', 'post_id'])
            ->prepBindExec([
                'user_id' => $userId,
                'post_id' => $postId
            ]);
    } elseif ($like === -1) //&& $this->query->rowCount() > 0
        $this->query->delete('post_liked')
            ->where('user_id', '=', ':userId')
            ->andwhere('post_id', '=', ':postId')
            ->prepBindExec(['postId' => $postId, 'userId' => $userId]);

        return new Response(302, ['Location' => '/dashboard']);
    }
}
