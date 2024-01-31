<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Post;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;

class PostHandlerPost implements RequestHandlerInterface
{
    public function __construct(private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $_SESSION['userId'] ?? 0;
        $parseBody = $request->getParsedBody();
        $crumbs = explode("/",$_SERVER['HTTP_REFERER'] ?? 'dashboard');

        if (isset($parseBody['title']) && isset($parseBody['post_text'])) {

            $title = $parseBody['title'];
            $postText = $parseBody['post_text'];
            $date = date('Y-m-d H:i');

            $this->query->insert('post', ['title', 'post_text', 'user_id', 'date'])
                ->prepBindExec(['title'=>$title,
                                'post_text'=>$postText,
                                'user_id'=>$userId,
                                'date'=>$date]);
        }
        return new Response(200, ['Location' => '/' . end($crumbs)]); // casser...
    }
}