<?php

namespace Lencse\Rectum\Testing\Facade;

use Lencse\Rectum\Testing\Web\AppRunner\WebAppSetup;

class AppTesting
{
    /**
     * @var string
     */
    public static $projectRoot = '';

    public static function webApplication(): WebAppSetup
    {
        return new WebAppSetup(self::$projectRoot . '/bootstrap/configuration.php');
    }
}
