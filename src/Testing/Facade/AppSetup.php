<?php

namespace Lencse\Rectum\Testing\Facade;

use GuzzleHttp\Psr7\ServerRequest;
use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\Configuration\CompositeApplicationConfig;
use Lencse\Rectum\Testing\Web\AppRunner\WebAppRunner;
use Lencse\Rectum\Testing\Web\Config\ConfigWithDI;
use Lencse\Rectum\Testing\Web\Config\RequestConfig;
use Lencse\Rectum\Testing\Web\Config\SuperGlobalsConfig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AppSetup
{
    /**
     * @var ApplicationConfig
     */
    protected $config;

    public function __construct(string $configFilePath)
    {
        $this->config = require $configFilePath;
    }
}
