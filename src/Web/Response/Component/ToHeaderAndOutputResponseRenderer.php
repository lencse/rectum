<?php

namespace Lencse\Rectum\Web\Response\Component;

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
