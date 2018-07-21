<?php

namespace Lencse\Rectum\Component\Request;

use Psr\Http\Message\ServerRequestInterface;

interface RequestReader
{

    public function create(): ServerRequestInterface;
}
