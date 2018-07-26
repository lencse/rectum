<?php

namespace Lencse\Rectum\Testing\Facade;

use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\Configuration\CompositeApplicationConfig;
use Lencse\Rectum\Framework\Application\Bootstrap;
use Lencse\Rectum\Testing\Web\ConfigWithDI;
use Lencse\Rectum\Testing\Web\ObserverConfig;
use Lencse\Rectum\Testing\Web\Response\ResponseObserver;
use Psr\Http\Message\ResponseInterface;

class WebAppRunner
{
    /**
     * @var ApplicationConfig
     */
    private $config;

    public function __construct(ApplicationConfig $config)
    {
        $this->config = $config;
    }

    public function run(): ResponseInterface
    {
        $observer = new ResponseObserver();
        $bootstrap = new Bootstrap(new CompositeApplicationConfig([
            $this->config,
            new ConfigWithDI(new ObserverConfig($observer)),
        ]));
        $bootstrap->createWebApplication()->run();

        return $observer->getResponse();
    }
}
