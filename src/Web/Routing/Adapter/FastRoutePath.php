<?php

namespace Lencse\Rectum\Web\Routing\Adapter;

use Lencse\Rectum\Web\Routing\Component\Route;

class FastRoutePath
{
    public function getPathWithParameterFormats(Route $route): string
    {
        $result = $route->getPath();
        foreach ($route->getParameterFormats() as $param => $format) {
            $result = preg_replace("/\{($param)\}/", "{\$1:$format}", $result);
        }

        return $result;
    }
}
