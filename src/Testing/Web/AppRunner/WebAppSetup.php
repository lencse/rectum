<?php

namespace Lencse\Rectum\Testing\Web\AppRunner;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Application\Configuration\CompositeApplicationConfig;
use Lencse\Rectum\Testing\Facade\AppSetup;
use Lencse\Rectum\Testing\Web\Configuration\ConfigWithDI;
use Lencse\Rectum\Testing\Web\Configuration\RequestConfig;
use Lencse\Rectum\Testing\Web\Configuration\SuperGlobalsConfig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WebAppSetup extends AppSetup
{
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
