<?php

namespace TestApp\Handler;

class OkMessage implements TestMessage
{

    public function getMessage(): string
    {
        return 'OK';
    }
}
