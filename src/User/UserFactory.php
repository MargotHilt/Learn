<?php

namespace Simovative\Kaboom\User;

use Psr\Http\Server\RequestHandlerInterface;
use Simovative\Kaboom\App\ApplicationFactory;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerDelete;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerGetData;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerPost;
use Simovative\Kaboom\User\Handler\Dashboard\DashboardHandlerUpdate;
use Simovative\Kaboom\User\Handler\Login\LoginGetHandler;
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
            $this->applicationFactory->createTwig());
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
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig());
    }

    public function createDashboardPostHandler(): RequestHandlerInterface
    {
        return new DashboardHandlerPost(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig());
    }

    public function createDashboardDeleteHandler(): RequestHandlerInterface
    {
        return new DashboardHandlerDelete(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig());
    }

    public function createDashboardUpdateHandler(): RequestHandlerInterface
    {
        return new DashboardHandlerUpdate(
            $this->applicationFactory->createPdo(),
            $this->applicationFactory->createTwig());
    }
}