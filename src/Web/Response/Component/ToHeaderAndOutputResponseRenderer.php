<?php

namespace Lencse\Rectum\Web\Response\Component;

use Lencse\Rectum\Web\Response\Component\HttpHeader;
use Lencse\Rectum\Web\Response\Component\Output;
use Lencse\Rectum\Web\Response\Component\ResponseRenderer;
use Psr\Http\Message\ResponseInterface;

class ToHeaderAndOutputResponseRenderer implements ResponseRenderer
{
    /**
     * @var HttpHeader
     */
    private $httpHeader;

    /**
     * @var Output
     */
    private $output;

    public function __construct(HttpHeader $httpHeader, Output $output)
    {
        $this->httpHeader = $httpHeader;
        $this->output = $output;
    }

    public function render(ResponseInterface $response): void
    {
        foreach ($response->getHeaders() as $header => $headerValue) {
            foreach ($headerValue as $value) {
                $this->httpHeader->sendHeader(sprintf('%s: %s', $header, $value));
            }
        }
        $this->output->print((string) $response->getBody());
    }
}
