<?php

namespace Lencse\Rectum\Testing\Facade;

use Lencse\Rectum\Component\Configuration\ApplicationConfig;
use Lencse\Rectum\Component\Configuration\CompositeApplicationConfig;
use Lencse\Rectum\Testing\Web\ConfigWithDI;
use Lencse\Rectum\Testing\Web\SuperGlobalsConfig;

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
}
