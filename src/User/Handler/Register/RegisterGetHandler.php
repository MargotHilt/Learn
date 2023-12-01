<?php

namespace Simovative\Kaboom\User\Handler\Register;

use http\Client\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

class RegisterGetHandler implements RequestHandlerInterface
{

    public function __construct(private PDO $pdo, private Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $parseBody = $request->getParsedBody();

        if (isset($parseBody['first_name']) && isset($parseBody['last_name']) && isset($parseBody['email']) && isset($parseBody['password'])) {


            $firstName = $parseBody['first_name'];
            $lastName = $parseBody['last_name'];
            $email = $parseBody['email'];
            $password = password_hash($parseBody['password'], PASSWORD_BCRYPT);

#username and password from db in pdo method.

            $sql = 'INSERT INTO 
            user (email, password, first_name, last_name) 
        VALUES 
            (:email, :password, :first_name, :last_name)';

            $statement = $this->pdo->prepare($sql);

            $statement->bindParam(':email', $email);
            $statement->bindParam(':password', $password);
            $statement->bindParam(':first_name', $firstName);
            $statement->bindParam(':last_name', $lastName);

            $statement->execute();
        }

        return new \GuzzleHttp\Psr7\Response(200, [], $this->renderer->render('register.twig', ['first_name' => 'first_name']));
    }
}