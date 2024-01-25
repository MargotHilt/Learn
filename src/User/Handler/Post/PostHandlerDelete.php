<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Post;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;

class PostHandlerDelete implements RequestHandlerInterface
{
    public function __construct(private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parseBody = $request->getParsedBody();

        $postId = $parseBody['hiddenNbr'] ?? 0;
        $crumbs = explode("/",$_SERVER['HTTP_REFERER'] ?? 'dashboard');


        $this->query->delete('post')
              ->where('id', '=', ':post_id')
              ->prepBindExec(['post_id'=>$postId]);

        return new Response(200, ['Location' => '/' . end($crumbs)]);
    }
}