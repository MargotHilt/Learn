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
    public function __construct(private PDO $pdo, private Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parseBody = $request->getParsedBody();
        if(isset($parseBody['delete'])) {

            $postId = $parseBody['delete'];

            /*$query = new UserRepository();
            $query->delete('test')
                  ->prepare()
                  ->bind('test')
                  ->exec();*/

            $sql = 'DELETE FROM `post`
            WHERE `id` = :post_id';

            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':post_id', $postId);
            $statement->execute();
        }
        return new \GuzzleHttp\Psr7\Response(200, ['Location' => '/dashboard']);
    }
}