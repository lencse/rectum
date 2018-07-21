<?php

namespace Lencse\Rectum\Framework\Web;

use Lencse\Rectum\Component\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Component\Request\FromGlobalsRequestReader;
use Lencse\Rectum\Component\Response\HttpHeader;
use Lencse\Rectum\Component\Response\Output;
use Lencse\Rectum\Component\RequestHandler\RequestHandler;
use Lencse\Rectum\Component\Request\RequestReader;
use Lencse\Rectum\Component\Response\ResponseRenderer;
use Lencse\Rectum\Component\Response\ToHeaderAndOutputResponseRenderer;
use Psr\Http\Server\RequestHandlerInterface;

class WebDI implements DependencyInjectionConfig
{

    public function bind(): array
    {
        return [
            HttpHeader::class => RealHttpHeader::class,
            Output::class => RealOutput::class,
            RequestHandlerInterface::class => RequestHandler::class,
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
