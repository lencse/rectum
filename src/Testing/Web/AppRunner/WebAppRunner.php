<?php

namespace Lencse\Rectum\Testing\Web\AppRunner;

use Lencse\Rectum\Application\Configuration\ApplicationConfig;
use Lencse\Rectum\Application\Configuration\CompositeApplicationConfig;
use Lencse\Rectum\Framework\Application\ApplicationSetup;
use Lencse\Rectum\Testing\Web\Configuration\ConfigWithDI;
use Lencse\Rectum\Testing\Web\Configuration\ObserverConfig;
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
        $bootstrap = new ApplicationSetup(new CompositeApplicationConfig([
            $this->config,
            new ConfigWithDI(new ObserverConfig($observer)),
        ]));
        $bootstrap->createWebApplication()->run();

        return $observer->getResponse();
    }
}
