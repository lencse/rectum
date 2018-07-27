<?php

namespace TestApp\Handler;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use TestApp\UseCase\Ok\OkUseCase;

class OkHandler
{
    /**
     * @var OkUseCase
     */
    private $okUseCase;

    public function __construct(OkUseCase $okUseCase)
    {
        $this->okUseCase = $okUseCase;
    }

    public function __invoke(): ResponseInterface
    {
        return new Response(200, ['Content-Type' => 'text/plain'], $this->okUseCase->getMessage());
    }
}
