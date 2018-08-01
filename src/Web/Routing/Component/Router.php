<?php

namespace Lencse\Rectum\Web\Routing\Component;

use Psr\Http\Message\ServerRequestInterface;

interface Router
{
    public function route(ServerRequestInterface $request): RoutingResult;
}
