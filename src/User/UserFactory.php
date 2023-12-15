<?php

namespace Simovative\Kaboom\User;

use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\ApplicationFactory;
use Simovative\Kaboom\User\Handler\BaseCompo\HeaderHandler;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerDelete;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerGetData;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerLike;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerPost;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerUpdate;
use Simovative\Kaboom\User\Handler\Login\LoginGetHandler;
use Simovative\Kaboom\User\Handler\LogoutHandler;
use Simovative\Kaboom\User\Handler\Login\IndexHandler;
use Simovative\Kaboom\User\Handler\Profile\ProfileHandler;
use Simovative\Kaboom\User\Handler\Register\RegisterGetHandler;

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

    public function createDashboardPostHandler(): RequestHandlerInterface
    {
        return new DashboardHandlerPost(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig(),
            $this->applicationFactory->createUserRepository());
    }

    public function createDashboardDeleteHandler(): RequestHandlerInterface
    {
        return new DashboardHandlerDelete(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig(),
            $this->applicationFactory->createUserRepository());
    }

    public function createDashboardUpdateHandler(): RequestHandlerInterface
    {
        return new DashboardHandlerUpdate(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig(),
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

    public function createDashboardLikeHandler(): RequestHandlerInterface
    {
        return new DashboardHandlerLike(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig(),
            $this->applicationFactory->createUserRepository());
    }

}