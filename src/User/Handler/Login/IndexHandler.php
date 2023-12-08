<?php

namespace Simovative\Kaboom\User\Handler\Login;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;
use GuzzleHttp\Psr7\Response;

class IndexHandler implements RequestHandlerInterface
{

    public function __construct(private PDO $pdo, private Environment $renderer)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $wrongData = false;
        return new Response(200, [], $this->renderer->render('index.twig', ['wrongData' => $wrongData]));
    }
}