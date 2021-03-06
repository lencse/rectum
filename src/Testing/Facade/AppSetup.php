<?php

namespace Lencse\Rectum\Testing\Facade;

use Lencse\Rectum\Application\Configuration\ApplicationConfig;

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
