<?php

namespace TestApp\UseCase\Ok;

class OkUseCase
{
    /**
     * @var TestMessage
     */
    private $message;

    public function __construct(TestMessage $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message->getMessage();
    }
}
