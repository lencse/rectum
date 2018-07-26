<?php

namespace Lencse\Rectum\Framework\Web\Request;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Adapter\Web\Request\FromGlobalsRequestReader;
use Lencse\Rectum\Component\Web\Request\RequestReader;

class RequestDI implements DependencyInjectionConfig
{

    public function bind(): array
    {
        return [
            RequestReader::class => FromGlobalsRequestReader::class,
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
            FromGlobalsRequestReader::class => [
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
