<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Login;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepository;
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

                $query = new UserRepository();
                $query->select('user',
                    ['email',
                     'password',
                     'id'])
                    ->where('email', '=', ':email')
                    ->prepBindExec(['email'=>$email]);
                $userData = $query->fetch();

                if ($query->rowCount() > 0 && password_verify($parseBody['password'], $userData['password'])) {
                    $_SESSION['userId'] = $userData['id'];
                    header('Location: /dashboard');
                    echo 'session started';
                } else {
                    echo 'wrong password or username';
                }
                return new Response(200, []);
            }
            else {
                return new Response(200, [], $this->renderer->render('index.twig'));
            }

    }
}