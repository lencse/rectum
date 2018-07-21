<?php

namespace Lencse\Rectum\Framework\Request;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Request\FromGlobalsRequestReader;
use Lencse\Rectum\Component\Request\RequestReader;

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
}
