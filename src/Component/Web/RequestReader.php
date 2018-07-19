<?php

namespace Lencse\Rectum\Component\Web;

use Psr\Http\Message\ServerRequestInterface;

interface RequestReader
{

    public function create(): ServerRequestInterface;
}
