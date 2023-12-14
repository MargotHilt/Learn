<?php

namespace Simovative\Kaboom\App\Session;

interface SessionInterface
{
    public function isLoggedIn(): bool;
}