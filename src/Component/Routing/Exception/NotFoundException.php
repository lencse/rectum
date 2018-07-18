<?php

namespace Lencse\Rectum\Component\Routing\Exception;

use Psr\Http\Message\ServerRequestInterface;

class NotFoundException extends RoutingException
{

    protected function createMessage(ServerRequestInterface $request): string
    {
        return sprintf('Not found: %s', $request->getUri()->getPath());
    }

    protected function getHttpCode(): int
    {
        return 404;
    }
}
