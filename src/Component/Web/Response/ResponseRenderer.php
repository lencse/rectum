<?php

namespace Lencse\Rectum\Component\Web\Response;

use Psr\Http\Message\ResponseInterface;

interface ResponseRenderer
{

    public function render(ResponseInterface $response): void;
}
