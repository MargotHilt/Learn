<?php

namespace Simovative\Kaboom\User\Handler\Login;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

class LoginGetHandler implements RequestHandlerInterface
{
    public function __construct(private PDO $pdo, private Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
            $parseBody = $request->getParsedBody();

            if (isset($parseBody['email'])) {

                $email = $parseBody['email'];

                $sql = '
                    SELECT 
                        `email`, 
                        `password`,
                        `id`
                    FROM `user` 
                    WHERE `email` = :email';

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);

                //FETCH_ASSOC makes the use of $userData['password'] instead of $userData[1] possible (line 39)

                if ($stmt->rowCount() > 0 && password_verify($parseBody['password'], $userData['password'])) {
                    $_SESSION['userId'] = $userData['id'];
                    header('Location: /dashboard');
                    echo 'session started';
                } else {
                    echo 'wrong password or username';
                }
                return new \GuzzleHttp\Psr7\Response(200, []);
            }
            else {
                return new \GuzzleHttp\Psr7\Response(200, [], $this->renderer->render('index.twig'));
            }

    }
}