<?php

namespace Lencse\Rectum\Component\Web;

use Lencse\Rectum\Component\Application\Application;
use Lencse\Rectum\Component\Web\Request\RequestReader;
use Lencse\Rectum\Component\Web\Response\ResponseRenderer;
use Psr\Http\Server\RequestHandlerInterface;

class WebApplication implements Application
{

    /**
     * @var RequestReader
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
        RequestReader $requestReader,
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
