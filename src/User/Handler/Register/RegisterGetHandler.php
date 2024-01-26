<?php
declare(strict_types=1);

namespace Simovative\Kaboom\User\Handler\Register;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\User\Model\User\UserRepository;
use Twig\Environment;

class RegisterGetHandler implements RequestHandlerInterface
{

    public function __construct(private readonly Environment $renderer)
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



            $filepath = $_FILES['profile_pic_upload']['tmp_name'];
            $fileSize = filesize($filepath);

            function alert($msg)
            {
                echo "<script>
            alert('$msg')
            window.location.href='/register'
            </script>";
                exit();
            }

            if($fileSize > 0 && $_FILES['profile_pic_upload']['type'] != 'image/jpeg' && $_FILES['profile_pic_upload']['type'] != 'image/png'){

                alert('The file format can ONLY be .png or .jpeg.');
            }

            if($fileSize > 3145728){
                alert('The file is too large');
            }

            $filename = $_FILES['profile_pic_upload']['name'];
            $folder = '/var/www/learn/public/asset/' . $filename;

            if($fileSize == 0){
                $filename = 'default-profilepic.png';
            }

            move_uploaded_file($filepath, $folder);

            $query = new UserRepository();
            $query->insert('user', ['email', 'password', 'first_name', 'last_name', 'profile_pic'])
                  ->prepBindExec(['email'=>$email,
                                  'password'=>$password,
                                  'first_name'=>$firstName,
                                  'last_name'=>$lastName,
                                  'profile_pic'=>$filename]);

            return new Response(302, [], $this->renderer->render('index.twig'));
        }

        return new Response(200, [], $this->renderer->render('register.twig'));
    }
}