<?php

namespace Test\Integration;

use Lencse\Rectum\Component\Web\Response\ResponseRenderer;
use Psr\Http\Message\ResponseInterface;

class MockRenderer implements ResponseRenderer
{

    /**
     * @var ResponseInterface
     */
    private $response;

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function render(ResponseInterface $response): void
    {
        $this->response = $response;
    }
}
