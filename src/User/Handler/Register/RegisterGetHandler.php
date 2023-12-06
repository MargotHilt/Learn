<?php

namespace Simovative\Kaboom\User\Handler\Register;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepository;
use Twig\Environment;

class RegisterGetHandler implements RequestHandlerInterface
{

    public function __construct(private readonly PDO $pdo, private readonly Environment $renderer)
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

            $query = new UserRepository();
            $query->insert('user', ['email', 'password', 'first_name', 'last_name'])
                  ->prepBindExec(['email'=>$email,
                                  'password'=>$password,
                                  'first_name'=>$firstName,
                                  'last_name'=>$lastName]);
        }

        return new Response(200, [], $this->renderer->render('register.twig'));
    }
}