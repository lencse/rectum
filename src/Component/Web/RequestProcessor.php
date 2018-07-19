<?php

namespace Lencse\Rectum\Component\Web;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestProcessor
{

    public function process(ServerRequestInterface $request): ResponseInterface;
}
