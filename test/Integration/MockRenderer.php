<?php

namespace Test\Integration;

use Lencse\Rectum\Component\Web\Response\ResponseRenderer;
use Psr\Http\Message\ResponseInterface;

class MockRenderer implements ResponseRenderer
{

    /**
     * @var ResponseInterface
     */
    public static $response;

    public function render(ResponseInterface $response): void
    {
        self::$response = $response;
    }
}
