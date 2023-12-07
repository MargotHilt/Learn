<?php

namespace Simovative\Kaboom\User\Handler;

use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

class LogoutHandler implements RequestHandlerInterface
{
    public function __construct(private readonly PDO $pdo, private readonly Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        unset($_SESSION['userId']);
        return new Response(200, ['Location' => '/']);
    }
}