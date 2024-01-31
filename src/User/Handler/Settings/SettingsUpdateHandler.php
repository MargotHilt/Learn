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
        $userId = $this->session->setSessionValue('userId') ?? 0;

        $uploadedFiles = $request->getUploadedFiles();
        $fileSize = $uploadedFiles['uploadfile']->getSize();

       function alert($msg)
        {
            echo "<script>
            alert('$msg')
            window.location.href='/settings'
            </script>";
            exit();
        }

        if($fileSize === false || $fileSize === 0){
            alert('There is no file to upload.');
        }

        if($uploadedFiles['uploadfile']->getClientMediaType() != 'image/jpeg' && $uploadedFiles['uploadfile']->getClientMediaType() != 'image/png'){

            alert('The file format can ONLY be .png or .jpeg.');
        }

        if($fileSize > 3145728){
            alert('The file is too large');
        }

            $filename = $uploadedFiles['uploadfile']->getClientFilename();
            $folder = '/var/www/learn/public/asset/' . $filename;

            $this->query->update('user', ['profile_pic' => 'profile_pic'])
                ->where('id', '=', ':userId')
                ->prepBindExec(['profile_pic' => $filename,
                    'userId' => $userId]);

            $uploadedFiles['uploadfile']->moveTo($folder);

            $_SESSION['userPic'] = $filename;

            return new Response(302, ['Location' => '/settings']);
    }
}