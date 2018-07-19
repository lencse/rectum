<?php

namespace Lencse\Rectum\Component\Web;

interface HttpHeader
{

    public function sendHeader(string $header): void;
}
