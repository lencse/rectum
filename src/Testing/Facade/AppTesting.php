<?php

namespace Lencse\Rectum\Testing\Facade;

class AppTesting
{
    /**
     * @var string
     */
    public static $projectRoot = '';

    public static function webApplication(): WebAppSetup
    {
        return new WebAppSetup(require self::$projectRoot . '/bootstrap/configuration.php');
    }
}
