<?php

namespace Lencse\Rectum\Framework\Web\Response;

use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\Response\Adapter\RealHttpHeader;
use Lencse\Rectum\Web\Response\Adapter\RealOutput;
use Lencse\Rectum\Web\Response\Component\HttpHeader;
use Lencse\Rectum\Web\Response\Component\Output;
use Lencse\Rectum\Web\Response\Component\ResponseRenderer;
use Lencse\Rectum\Web\Response\Component\ToHeaderAndOutputResponseRenderer;

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
