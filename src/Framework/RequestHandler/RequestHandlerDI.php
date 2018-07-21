<?php

namespace Lencse\Rectum\Framework\RequestHandler;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\RequestHandler\RequestHandler;
use Psr\Http\Server\RequestHandlerInterface;

class RequestHandlerDI implements DependencyInjectionConfig
{

    public function bind(): array
    {
        return [
            RequestHandlerInterface::class => RequestHandler::class
        ];
    }

    public function factory(): array
    {
        return [];
    }

    public function setup(): array
    {
        return [];
    }

    public function wire(): array
    {
        return [];
    }
}
