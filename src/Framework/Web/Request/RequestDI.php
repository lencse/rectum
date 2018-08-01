<?php

namespace Lencse\Rectum\Framework\Web\Request;

use Lencse\Rectum\Web\Request\Adapter\FromGlobalsRequestSource;
use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\Request\Component\RequestSource;

class RequestDI implements DependencyInjectionConfig
{
    public function bind(): array
    {
        return [
            RequestSource::class => FromGlobalsRequestSource::class,
        ];
    }

    public function factory(): array
    {
        return [];
    }

    /**
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function setup(): array
    {
        return [
            FromGlobalsRequestSource::class => [
                'serverArr' => $_SERVER,
                'getArr' => $_GET,
            ]
        ];
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
