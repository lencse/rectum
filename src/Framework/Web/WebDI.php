<?php

namespace Lencse\Rectum\Framework\Web;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Web\FromGlobalsRequestReader;
use Lencse\Rectum\Component\Web\HttpHeader;
use Lencse\Rectum\Component\Web\Output;
use Lencse\Rectum\Component\Web\RequestProcessorByRouter;
use Lencse\Rectum\Component\Web\RequestReader;
use Lencse\Rectum\Component\Web\ResponseRenderer;
use Lencse\Rectum\Component\Web\ToHeaderAndOutputResponseRenderer;
use Psr\Http\Server\RequestHandlerInterface;

class WebDI implements DependencyInjectionConfig
{

    public function bind(): array
    {
        return [
            HttpHeader::class => RealHttpHeader::class,
            Output::class => RealOutput::class,
            RequestHandlerInterface::class => RequestProcessorByRouter::class,
            RequestReader::class => FromGlobalsRequestReader::class,
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
