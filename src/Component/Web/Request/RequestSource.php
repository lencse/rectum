<?php

namespace Lencse\Rectum\Component\Web\Request;

use Psr\Http\Message\ServerRequestInterface;

interface RequestSource
{
    public function create(): ServerRequestInterface;
}
