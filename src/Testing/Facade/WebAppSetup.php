<?php

namespace Lencse\Rectum\Testing\Facade;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\Configuration\CompositeApplicationConfig;
use Lencse\Rectum\Testing\Web\ConfigWithDI;
use Lencse\Rectum\Testing\Web\RequestConfig;
use Lencse\Rectum\Testing\Web\SuperGlobalsConfig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WebAppSetup
{
    /**
     * @var ApplicationConfig
     */
    private $config;

    public function __construct(ApplicationConfig $config)
    {
        $this->config = $config;
    }

    public function withSuperGlobals(array $superGlobals): WebAppRunner
    {
        return new WebAppRunner(
            new CompositeApplicationConfig([
                $this->config,
                new ConfigWithDI(new SuperGlobalsConfig($superGlobals))
            ])
        );
    }

    public function withRequest(ServerRequestInterface $request): WebAppRunner
    {
        return new WebAppRunner(
            new CompositeApplicationConfig([
                $this->config,
                new ConfigWithDI(new RequestConfig($request))
            ])
        );
    }

    public function runWithUri(string $uri): ResponseInterface
    {
        return $this->withRequest(new ServerRequest('GET', $uri))->run();
    }
}
