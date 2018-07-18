<?php

namespace Test\Unit\Framework\Routing\Handler;

use Psr\Http\Message\ServerRequestInterface;

class TestHandler
{

    public function __invoke(ServerRequestInterface $request): string
    {
        return $request->getBody();
    }
}
