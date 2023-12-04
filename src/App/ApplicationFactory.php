<?php

namespace Simovative\Kaboom\App;

use PDO;
use Simovative\Kaboom\User\UserFactory;
use Simovative\Kaboom\User\UserFactoryInterface;
use Twig\Environment;

class ApplicationFactory implements ApplicationFactoryInterface
{
    public function createUserFactory(): UserFactoryInterface
    {
        return new UserFactory($this);
    }

    public function createPdo(): PDO
    {
        return new PDO('mysql:host=mysql_db;dbname=kaboom', 'root', 'root');
    }

    public function createTwig(): Environment
    {
        $loader = new \Twig\Loader\FilesystemLoader('../src/User/Templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        return $twig;
    }
}