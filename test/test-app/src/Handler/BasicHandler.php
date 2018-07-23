<?php

namespace TestApp\Handler;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class BasicHandler
{

    /**
     * @var TestMessage
     */
    private $message;

    public function __construct(TestMessage $message)
    {
        $this->message = $message;
    }

    public function __invoke(): ResponseInterface
    {
        return new Response(200, [], $this->message->getMessage());
    }
}
