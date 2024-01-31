<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Post;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;

class PostHandlerUpdate implements RequestHandlerInterface
{

    public function __construct(private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parseBody = $request->getParsedBody();
        $url = explode("/",$_SERVER['HTTP_REFERER'] ?? 'dashboard');
        $crumbs = array_slice($url, 3);

        if(isset($parseBody['update'])) {

            $postId = $parseBody['hiddenNbr'];
            $postTitle = $parseBody['title'];
            $postText =  $parseBody['post_text'];

            $this->query->update('post', ['title' => 'title', 'post_text' => 'postText', 'is_edited' => 'isEdited'])
                ->where('id', '=', ':post_id')
                ->prepBindExec(['title' => $postTitle, 'postText' => $postText, 'post_id' => $postId, 'isEdited' => 1]);

        }
        return new Response(200, ['Location' => '/' . implode("/", $crumbs)]);
    }
}