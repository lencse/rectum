<?php

namespace Lencse\Rectum\Component\Web\Response;

interface HttpHeader
{
    public function sendHeader(string $header): void;
}
