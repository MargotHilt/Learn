<?php

class MyHandler
{
    public static function handleServerRequest($method, $attribute) {

        $request = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
        switch ($method) {
            case 'post':
                return $request->getParsedBody()[$attribute];

            case 'get':
               return $request->getQueryParams()[$attribute];

        }
    }
}