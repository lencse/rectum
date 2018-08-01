<?php

namespace Lencse\Rectum\Web\Routing\Exception;

use Lencse\Rectum\Web\Routing\Exception\RoutingException;
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
