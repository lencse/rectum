<?php

namespace Lencse\Rectum\Web\Response\Component;

interface HttpHeader
{
    public function sendHeader(string $header): void;
}
