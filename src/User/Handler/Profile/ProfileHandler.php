<?php

namespace Simovative\Kaboom\User\Handler\Profile;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

class ProfileHandler implements RequestHandlerInterface
{

    public function __construct(private readonly PDO $pdo, private readonly Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        return new Response(200, [], $this->renderer->render('profile.twig', [
        ]));
    }

}