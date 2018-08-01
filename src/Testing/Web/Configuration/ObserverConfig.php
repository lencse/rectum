<?php

namespace Lencse\Rectum\Testing\Web\Configuration;

use Lencse\Rectum\DependencyInjection\Configuration\DependencyInjectionConfig;
use Lencse\Rectum\Web\Response\Component\ResponseRenderer;

class ObserverConfig implements DependencyInjectionConfig
{
    /**
     * @var ResponseRenderer
     */
    private $responseRenderer;

    public function __construct(ResponseRenderer $responseRenderer)
    {
        $this->responseRenderer = $responseRenderer;
    }

    public function bind(): array
    {
        return [];
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
        return [
            ResponseRenderer::class => $this->responseRenderer
        ];
    }
}
