<?php

namespace Simovative\Kaboom\App\Emitter;

use Psr\Http\Message\ResponseInterface;

interface EmitterInterface
{
    public function emit(ResponseInterface $response): void;
}