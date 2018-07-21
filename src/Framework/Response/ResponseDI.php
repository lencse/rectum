<?php

namespace Lencse\Rectum\Framework\Response;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Response\HttpHeader;
use Lencse\Rectum\Component\Response\Output;
use Lencse\Rectum\Component\Response\ResponseRenderer;
use Lencse\Rectum\Component\Response\ToHeaderAndOutputResponseRenderer;

class ResponseDI implements DependencyInjectionConfig
{

    public function bind(): array
    {
        return [
            HttpHeader::class => RealHttpHeader::class,
            Output::class => RealOutput::class,
            ResponseRenderer::class => ToHeaderAndOutputResponseRenderer::class
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
        return [];
    }

    public function wire(): array
    {
        return [];
    }
}
