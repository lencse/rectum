<?php

namespace Lencse\Rectum\Component\Response;

use Psr\Http\Message\ResponseInterface;

interface ResponseRenderer
{

    public function render(ResponseInterface $response): void;
}
