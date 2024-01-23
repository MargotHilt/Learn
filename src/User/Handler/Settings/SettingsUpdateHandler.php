<?php

namespace Simovative\Kaboom\User\Handler\Settings;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\Session\SessionInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class SettingsUpdateHandler implements RequestHandlerInterface
{
    public function __construct(
        private SessionInterface $session,
        private Environment $renderer,
        private UserRepositoryInterface $query
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //todo mysql method to update profilepic col, and find a way to add link to asset
        $userId = $this->session->setSessionValue('userId') ?? 0;

        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];
        $folder = '/var/www/learn/public/asset/' . $filename;

        //sql update
        $this->query->update('user', ['profile_pic' => 'profile_pic'])
                    ->where('id', '=', ':userId')
                    ->prepBindExec(['profile_pic' => $filename,
                                    'userId' => $userId]);

        move_uploaded_file($tempname, $folder);

       $_SESSION['userPic'] = $filename;

       /* if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>  Image uploaded successfully!</h3>";
        } else {
            echo "<h3>  Failed to upload image!</h3>";
        }*/

        return new Response(302, ['Location' => '/settings']);
    }
}