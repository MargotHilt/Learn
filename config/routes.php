<?php

use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\ApplicationFactory;
use \Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

session_start();
$routes = new RouteCollection();

$route = new Route('/', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createIndexHandler();
}]);
$routes->add('index', $route);

$route = new Route('/login', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createLoginGetHandler();
}]);
$routes->add('login', $route);

$route = new Route('/register', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createRegisterGetHandler();
}]);
$routes->add('register', $route);

$route = new Route('/dashboard', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
        return $factory->createUserFactory()
            ->createDashboardGetDataHandler();
}]);
$routes->add('dashboard', $route);

$route = new Route('/dashboard/post/update', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createDashboardUpdateHandler();
}]);
$routes->add('update', $route);

$route = new Route('/dashboard/post/delete', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createDashboardDeleteHandler();
}]);
$routes->add('delete', $route);

$route = new Route('/dashboard/post/post', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createDashboardPostHandler();
}]);
$routes->add('post', $route);

$route = new Route('/logout', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createLogoutHandler();
}]);
$routes->add('logout', $route);

$route = new Route('/profile', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createProfileHandler();
}]);
$routes->add('profile', $route);

return $routes;