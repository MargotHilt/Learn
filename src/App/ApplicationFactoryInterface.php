<?php

namespace Simovative\Kaboom\App;

use PDO;

interface ApplicationFactoryInterface
{
    public function createPdo(): PDO;
}