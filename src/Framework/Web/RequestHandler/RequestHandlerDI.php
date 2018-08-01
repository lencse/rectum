<?php

namespace Lencse\Rectum\Framework\Web\RequestHandler;

use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\RequestHandler\Component\RequestHandler;
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

    public function instance(): array
    {
        return [];
    }
}
