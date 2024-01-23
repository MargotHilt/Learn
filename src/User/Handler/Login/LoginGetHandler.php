<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Login;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepository;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class LoginGetHandler implements RequestHandlerInterface
{
    public function __construct(private PDO $pdo, private Environment $renderer, private UserRepositoryInterface $query)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parseBody = $request->getParsedBody();

        if (isset($parseBody['email']) && isset($parseBody['password'])) {

            $email = $parseBody['email'];

            $this->query->select('user',
                ['email',
                 'password',
                 'id',
                 'first_name',
                 'last_name',
                 'profile_pic'])
                ->where('email', '=', ':email')
                ->prepBindExec(['email'=>$email]);
            $userData = $this->query->fetch();

            if ($this->query->rowCount() > 0 && password_verify($parseBody['password'], $userData['password'])) {

                $_SESSION['userId'] = $userData['id'];
                $_SESSION['userName'] = $userData['first_name'];
                $_SESSION['userLastName'] = $userData['last_name'];
                $_SESSION['userPic'] = $userData['profile_pic'];
                //add other session variable like name

                return new Response(302, ['Location' => '/dashboard']);
            } else {
                $wrongData = true;
                return new Response(200, [], $this->renderer->render('index.twig', [
                    'wrongData' => $wrongData
                ]));
            }
        }
        else {
            return new Response(200, []);
        }

    }
}