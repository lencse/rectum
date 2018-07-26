<?php

namespace Lencse\Rectum\Framework\Web\Response;

use Lencse\Rectum\Adapter\Web\Response\RealHttpHeader;
use Lencse\Rectum\Adapter\Web\Response\RealOutput;
use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Web\Response\HttpHeader;
use Lencse\Rectum\Component\Web\Response\Output;
use Lencse\Rectum\Component\Web\Response\ResponseRenderer;
use Lencse\Rectum\Component\Web\Response\ToHeaderAndOutputResponseRenderer;

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

    public function instance(): array
    {
        return [];
    }
}
