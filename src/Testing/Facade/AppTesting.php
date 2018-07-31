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
        return new WebAppSetup(self::getProjectRoot() . '/bootstrap/configuration.php');
    }

    private static function getProjectRoot(): string
    {
        return self::$projectRoot ?? self::findProjectRoot();
    }

    /**
     * @codeCoverageIgnore
     */
    private static function findProjectRoot(): string
    {
        $dir = __DIR__;
        while (!file_exists($dir . '/vendor/lencse/rectum')) {
            $dir = dirname($dir);
        }

        return $dir;
    }
}
