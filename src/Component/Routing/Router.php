<?php

namespace Lencse\Rectum\Component\Routing;

use Psr\Http\Message\ServerRequestInterface;

interface Router
{

    public function route(ServerRequestInterface $request): RoutingResult;
}
