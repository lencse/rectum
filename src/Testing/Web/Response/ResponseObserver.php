<?php

namespace Lencse\Rectum\Testing\Web\Response;

use Lencse\Rectum\Web\Response\Component\ResponseRenderer;
use Psr\Http\Message\ResponseInterface;

class ResponseObserver implements ResponseRenderer
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
