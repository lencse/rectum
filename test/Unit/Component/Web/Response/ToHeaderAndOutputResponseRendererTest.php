<?php

namespace Test\Unit\Component\Web\Response;

use GuzzleHttp\Psr7\Response;
use Lencse\Rectum\Component\Web\Response\HttpHeader;
use Lencse\Rectum\Component\Web\Response\Output;
use Lencse\Rectum\Component\Web\Response\ToHeaderAndOutputResponseRenderer;
use PHPUnit\Framework\TestCase;

class ToHeaderAndOutputResponseRendererTest extends TestCase implements HttpHeader, Output
{
    /**
     * @var string[]
     */
    private $headers = [];

    /**
     * @var string
     */
    private $output = '';

    public function sendHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    public function print(string $content): void
    {
        $this->output = $content;
    }

    public function testRender()
    {
        $renderer = new ToHeaderAndOutputResponseRenderer($this, $this);
        $response = new Response(200, ['Content-Type' => 'text/plain'], 'Body');
        $renderer->render($response);
        $this->assertEquals(['Content-Type: text/plain'], $this->headers);
        $this->assertEquals('Body', $this->output);
    }
}
