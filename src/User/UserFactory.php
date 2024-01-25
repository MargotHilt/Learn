<?php

namespace Simovative\Kaboom\User;

use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\ApplicationFactory;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerGetData;
use Simovative\Kaboom\User\Handler\Login\IndexHandler;
use Simovative\Kaboom\User\Handler\Login\LoginGetHandler;
use Simovative\Kaboom\User\Handler\LogoutHandler;
use Simovative\Kaboom\User\Handler\Post\PostHandlerDelete;
use Simovative\Kaboom\User\Handler\Post\PostHandlerLike;
use Simovative\Kaboom\User\Handler\Post\PostHandlerPost;
use Simovative\Kaboom\User\Handler\Post\PostHandlerUpdate;
use Simovative\Kaboom\User\Handler\Profile\ProfileHandler;
use Simovative\Kaboom\User\Handler\Register\RegisterGetHandler;
use Simovative\Kaboom\User\Handler\Settings\SettingsHandler;
use Simovative\Kaboom\User\Handler\Settings\SettingsUpdateHandler;

class UserFactory implements UserFactoryInterface
{
    public function __construct(private ApplicationFactory $applicationFactory)
    {
    }

    public function createLoginGetHandler(): RequestHandlerInterface
    {
        return new LoginGetHandler(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig(),
            $this->applicationFactory->createUserRepository());
    }

    public function createRegisterGetHandler(): RequestHandlerInterface
    {
        return new RegisterGetHandler(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig());
    }

    public function createDashboardGetDataHandler(): RequestHandlerInterface
    {
        return new DashboardHandlerGetData(
            $this->applicationFactory->createSession(),
            $this->applicationFactory->createTwig(),
            $this->applicationFactory->createUserRepository());
    }

    public function createPostPostHandler(): RequestHandlerInterface
    {
        return new PostHandlerPost(
            $this->applicationFactory->createUserRepository());
    }

    public function createPostDeleteHandler(): RequestHandlerInterface
    {
        return new PostHandlerDelete(
            $this->applicationFactory->createUserRepository());
    }

    public function createPostUpdateHandler(): RequestHandlerInterface
    {
        return new PostHandlerUpdate(
            $this->applicationFactory->createUserRepository());
    }

    public function createPostLikeHandler(): RequestHandlerInterface
    {
        return new PostHandlerLike(
            $this->applicationFactory->createUserRepository());
    }

    public function createLogoutHandler(): RequestHandlerInterface
    {
        return new LogoutHandler(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig());
    }

    public function createIndexHandler(): RequestHandlerInterface
    {
        return new IndexHandler(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig(),
            $this->applicationFactory->createSession());
    }

    public function createProfileHandler(): RequestHandlerInterface
    {
        return new ProfileHandler(
            $this->applicationFactory->createSession(),
            $this->applicationFactory->createTwig(),
            $this->applicationFactory->createUserRepository());
    }

    public function createSettingsHandler(): RequestHandlerInterface
    {
        return new SettingsHandler(
            $this->applicationFactory->createSession(),
            $this->applicationFactory->createTwig(),
            $this->applicationFactory->createUserRepository());
    }

    public function createSettingsUpdateHandler(): RequestHandlerInterface
    {
        return new SettingsUpdateHandler(
            $this->applicationFactory->createSession(),
            $this->applicationFactory->createTwig(),
            $this->applicationFactory->createUserRepository());
    }

}