<?php

namespace Simovative\Kaboom\User\Handler\Dashboard;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepository;
use Twig\Environment;

class DashboardHandlerDelete implements RequestHandlerInterface
{
    public function __construct(private readonly PDO $pdo, private readonly Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parseBody = $request->getParsedBody();
        if(isset($parseBody['delete'])) {

            $postId = $parseBody['delete'];

            $query = new UserRepository();
            $query->delete('post')
                  ->where('id', '=', ':post_id')
                  ->prepBindExec(['post_id'=>$postId]);

        }
        return new \GuzzleHttp\Psr7\Response(200, ['Location' => '/dashboard']);
    }
}