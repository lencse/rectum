<?php

namespace Lencse\Rectum\Framework\Web\Routing;

use Lencse\Rectum\Component\Web\Routing\Route;

class FastRoutePath
{

    public function getPathWithParameterFormats(Route $route): string
    {
        $result = $route->getPath();
        foreach ($route->getParameterFormats() as $param => $format) {
            /** @var string $result */
            $result = preg_replace("/\{($param)\}/", "{\$1:$format}", $result);
        }

        return $result;
    }
}
