<?php

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\ApplicationFactory;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require '../vendor/autoload.php';

$request = ServerRequest::fromGlobals();
$applicationFactory = new ApplicationFactory();

$routes = require __DIR__.'/../config/routes.php';

$matcher = new UrlMatcher($routes, new RequestContext());
try {
    $parameters = $matcher->match($request->getUri()->getPath());
    $handler = ($parameters['handler'])($applicationFactory);

    if ($handler instanceof RequestHandlerInterface) {
        $response = $handler->handle($request);
        $applicationFactory->emitter()->emit($response);
    }
    //echo $parameters['id'] ?? 'no id';
} catch(ResourceNotFoundException) {
    echo '404 not found';
}

