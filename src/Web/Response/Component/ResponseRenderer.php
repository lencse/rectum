<?php

namespace Lencse\Rectum\Web\Response\Component;

use Psr\Http\Message\ResponseInterface;

interface ResponseRenderer
{
    public function render(ResponseInterface $response): void;
}
