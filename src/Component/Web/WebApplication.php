<?php

namespace Lencse\Rectum\Component\Web;

use Lencse\Rectum\Component\Application\Application;

class WebApplication implements Application
{

    /**
     * @var RequestReader
     */
    private $requestReader;

    /**
     * @var RequestProcessor
     */
    private $requestProcessor;

    /**
     * @var ResponseRenderer
     */
    private $responseRenderer;

    public function __construct(
        RequestReader $requestReader,
        RequestProcessor $requestProcessor,
        ResponseRenderer $responseRenderer
    ) {
        $this->requestReader = $requestReader;
        $this->requestProcessor = $requestProcessor;
        $this->responseRenderer = $responseRenderer;
    }


    public function run(): void
    {
        $request = $this->requestReader->create();
        $response = $this->requestProcessor->process($request);
        $this->responseRenderer->render($response);
    }
}
