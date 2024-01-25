<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Post;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class PostHandlerUpdate implements RequestHandlerInterface
{

    public function __construct(private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parseBody = $request->getParsedBody();
        $crumbs = explode("/",$_SERVER['HTTP_REFERER']);

        if(isset($parseBody['update'])) {

            $postId = $parseBody['hiddenNbr'];
            $postTitle = $parseBody['title'];
            $postText =  $parseBody['post_text'];

            $this->query->update('post', ['title' => 'title', 'post_text' => 'postText'])
                ->where('id', '=', ':post_id')
                ->prepBindExec(['title' => $postTitle, 'postText' => $postText, 'post_id' => $postId]);

        }
        return new Response(200, ['Location' => '/' . end($crumbs)]);
    }
}