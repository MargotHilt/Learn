<?php

namespace Simovative\Kaboom\User\Handler\Dashboard;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

class DashboardHandlerPost implements RequestHandlerInterface
{
    public function __construct(private PDO $pdo, private Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $_SESSION['userId'] ?? 0;
        $parseBody = $request->getParsedBody();

        if (isset($_POST['title']) && isset($_POST['post_text'])) {

            $title = $parseBody['title'];
            $postText = $parseBody['post_text'];

            $sql = 'INSERT INTO 
            post (title, post_text, user_id) 
            VALUES 
            (:title, :post_text, :user_id)';

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam(':title', $title);
            $statement->bindParam(':post_text', $postText);
            $statement->bindParam(':user_id', $userId);

            $statement->execute();
        }
        return new \GuzzleHttp\Psr7\Response(200, ['Location' => '/dashboard']);
    }
}