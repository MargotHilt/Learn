<?php

namespace Simovative\Kaboom\User\Handler\Settings;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\Session\SessionInterface;
use Simovative\Kaboom\User\Model\User\UserRepositoryInterface;
use Twig\Environment;

class SettingsHandler implements RequestHandlerInterface
{
    public function __construct(
        private SessionInterface $session,
        private Environment $renderer,
        private UserRepositoryInterface $query
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        //$userId = $this->session->setSessionValue('userId') ?? 0;
        $userName = $this->session->setSessionValue('userName') ?? 'User';
        $userLastName = $this->session->setSessionValue('userLastName') ?? 'User';
        $userPic = $this->session->setSessionValue('userPic') ?? '';


        return new Response(200, [], $this->renderer->render('settings.twig',
            [
            'userName' => $userName,
            'userLastName' => $userLastName,
            'userPic' => $userPic
            ]
        ));
    }
}