<?php

namespace TestApp;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class Handler
{

    public function __invoke(): ResponseInterface
    {
        return new Response(200, [], 'OK');
    }
}
