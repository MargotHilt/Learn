<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Dashboard;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepository;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class DashboardHandlerPost implements RequestHandlerInterface
{
    public function __construct(private readonly PDO $pdo, private readonly Environment $renderer, private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $_SESSION['userId'] ?? 0;
        $parseBody = $request->getParsedBody();

        if (isset($parseBody['title']) && isset($parseBody['post_text'])) {

            $title = $parseBody['title'];
            $postText = $parseBody['post_text'];
            $date = date('Y-m-d H:i');

            //add timeOfPublication col in table

            $this->query->insert('post', ['title', 'post_text', 'user_id', 'date'])
                ->prepBindExec(['title'=>$title,
                                'post_text'=>$postText,
                                'user_id'=>$userId,
                                'date'=>$date]);
        }
        return new Response(200, ['Location' => '/dashboard']);
    }
}