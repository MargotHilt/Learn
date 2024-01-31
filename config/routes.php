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

$route = new Route('/post/updat', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createPostUpdateHandler();
}]);
$routes->add('updat', $route);

$route = new Route('/post/delete', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createPostDeleteHandler();
}]);
$routes->add('delete', $route);

$route = new Route('/post/post', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createPostPostHandler();
}]);
$routes->add('post', $route);

$route = new Route('/post/like', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createPostLikeHandler();
}]);
$routes->add('like', $route);

$route = new Route('/logout', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createLogoutHandler();
}]);
$routes->add('logout', $route);

$route = new Route('/profile/{ownName}', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createProfileHandler();
}]);
$routes->add('{ownName}', $route);

$route = new Route('/profile/user/{name}', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createOthersProfileHandler();
}]);
$routes->add('{name}', $route);

$route = new Route('/settings', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createSettingsHandler();
}]);
$routes->add('settings', $route);

$route = new Route('/settings/update', ['handler' => function(ApplicationFactory $factory): RequestHandlerInterface {
    return $factory->createUserFactory()
        ->createSettingsUpdateHandler();
}]);
$routes->add('update', $route);

return $routes;