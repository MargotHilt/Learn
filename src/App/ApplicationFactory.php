<?php
declare(strict_types=1);

namespace Simovative\Kaboom\App;

use PDO;
use Simovative\Kaboom\App\Emitter\Emitter;
use Simovative\Kaboom\App\Emitter\EmitterInterface;
use Simovative\Kaboom\User\UserFactory;
use Simovative\Kaboom\User\UserFactoryInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

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
        $loader = new FilesystemLoader('../src/User/Templates');
        $twig = new Environment($loader, [
            'cache' => false,
        ]);
        return $twig;
    }

    public function emitter(): EmitterInterface
    {
        return new Emitter();
    }
}