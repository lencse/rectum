<?php

namespace TestApp\Handler;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use TestApp\UseCase\Hello\HelloUseCase;

class HelloHandler
{
    /**
     * @var HelloUseCase
     */
    private $helloUseCase;

    public function __construct(HelloUseCase $helloUseCase)
    {
        $this->helloUseCase = $helloUseCase;
    }

    public function __invoke(string $name): ResponseInterface
    {
        return new Response(200, ['Content-Type' => 'text/plain'], $this->helloUseCase->getMessage($name));
    }
}
