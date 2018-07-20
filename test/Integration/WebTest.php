<?php

namespace Test\Integration;

use Lencse\Rectum\Component\Web\WebApplication;
use Lencse\Rectum\Framework\Application\Bootstrap;
use PHPUnit\Framework\TestCase;

class WebTest extends TestCase
{

    public function testWeb()
    {
        $bootstrap = new Bootstrap();
        $web = $bootstrap->createWebApplication();
        $this->assertTrue($web instanceof WebApplication);
    }
}
