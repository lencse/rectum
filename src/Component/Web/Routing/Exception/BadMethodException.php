<?php

namespace Lencse\Rectum\Component\Web\Routing\Exception;

use Psr\Http\Message\ServerRequestInterface;

class BadMethodException extends RoutingException
{

    protected function createMessage(ServerRequestInterface $request): string
    {
        return sprintf('Method not allowed: %s on "%s"', $request->getMethod(), $request->getUri()->getPath());
    }

    protected function getHttpCode(): int
    {
        return 405;
    }
}
