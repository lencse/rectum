<?php

namespace Lencse\Rectum\Component\Web\Request;

use Psr\Http\Message\ServerRequestInterface;

interface RequestReader
{

    public function create(): ServerRequestInterface;
}
