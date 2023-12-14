<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Dashboard;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class DashboardHandlerDelete implements RequestHandlerInterface
{
    public function __construct(private readonly PDO $pdo, private readonly Environment $renderer, private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parseBody = $request->getParsedBody();

        $postId = $parseBody['hiddenNbr'];

        $this->query->delete('post')
              ->where('id', '=', ':post_id')
              ->prepBindExec(['post_id'=>$postId]);

        return new Response(200, ['Location' => '/dashboard']);
    }
}