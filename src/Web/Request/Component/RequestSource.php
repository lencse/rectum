<?php

namespace Lencse\Rectum\Web\Request\Component;

use Psr\Http\Message\ServerRequestInterface;

interface RequestSource
{
    public function create(): ServerRequestInterface;
}
