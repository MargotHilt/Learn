<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Dashboard;

use PDO;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepository;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class DashboardHandlerUpdate implements RequestHandlerInterface
{

    public function __construct(private readonly PDO $pdo, private readonly Environment $renderer, private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parseBody = $request->getParsedBody();

        if(isset($parseBody['update'])) {

            $postId = $parseBody['hiddenNbr'];
            $postTitle = $parseBody['title'];
            $postText =  $parseBody['post_text'];

            $this->query->update('post', ['title' => 'title', 'post_text' => 'postText'])
                ->where('id', '=', ':post_id')
                ->prepBindExec(['title' => $postTitle, 'postText' => $postText, 'post_id' => $postId]);

        }
        return new Response(200, ['Location' => '/dashboard']);
    }
}