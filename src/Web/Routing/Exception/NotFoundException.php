<?php

namespace Lencse\Rectum\Web\Routing\Exception;

use Lencse\Rectum\Web\Routing\Exception\RoutingException;
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
