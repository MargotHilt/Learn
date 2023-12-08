<?php
declare(strict_types=1);

namespace Simovative\Kaboom\App\Emitter;

use Psr\Http\Message\ResponseInterface;

class Emitter implements EmitterInterface
{
    public function emit(ResponseInterface $response): void
    {
        $reasonPhrase = $response->getReasonPhrase();
        $statusCode = $response->getStatusCode();

        $statusHeader = sprintf(
            'HTTP/%s %d%s',
            $response->getProtocolVersion(),
            $statusCode,
            ($reasonPhrase !== '' ? ' ' . $reasonPhrase : '')
        );

        header($statusHeader, true, $statusCode);

        foreach ($response->getHeaders() as $header => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $header, $value)); //spring auto concat
                //header('Location: /');
            }
        }

        echo $response->getBody();
    }
}