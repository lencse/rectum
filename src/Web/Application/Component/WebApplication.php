<?php

namespace Lencse\Rectum\Web\Application\Component;

use Lencse\Rectum\Application\Component\Application;
use Lencse\Rectum\Web\Request\Component\RequestSource;
use Lencse\Rectum\Web\Response\Component\ResponseRenderer;
use Psr\Http\Server\RequestHandlerInterface;

class WebApplication implements Application
{
    /**
     * @var RequestSource
     */
    private $requestReader;

    /**
     * @var RequestHandlerInterface
     */
    private $requestHandler;

    /**
     * @var ResponseRenderer
     */
    private $responseRenderer;

    public function __construct(
        RequestSource $requestReader,
        RequestHandlerInterface $requestHandler,
        ResponseRenderer $responseRenderer
    ) {
        $this->requestReader = $requestReader;
        $this->requestHandler = $requestHandler;
        $this->responseRenderer = $responseRenderer;
    }

    public function run(): void
    {
        $request = $this->requestReader->create();
        $response = $this->requestHandler->handle($request);
        $this->responseRenderer->render($response);
    }
}
