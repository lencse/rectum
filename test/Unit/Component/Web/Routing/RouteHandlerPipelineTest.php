<?php

namespace Test\Unit\Component\Web\Routing;

use Lencse\Rectum\Component\Web\Routing\Exception\EmptyRouteHandlerPipelineException;
use Lencse\Rectum\Component\Web\Routing\RouteHandlerPipeline;
use PHPUnit\Framework\TestCase;

class RouteHandlerPipelineTest extends TestCase
{


    public function testValidationn()
    {
        $this->expectException(EmptyRouteHandlerPipelineException::class);
        new RouteHandlerPipeline([]);
    }
}
