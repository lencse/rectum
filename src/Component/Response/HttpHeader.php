<?php

namespace Lencse\Rectum\Component\Response;

interface HttpHeader
{

    public function sendHeader(string $header): void;
}
