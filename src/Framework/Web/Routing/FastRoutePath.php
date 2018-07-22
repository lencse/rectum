<?php

namespace Lencse\Rectum\Framework\Web\Routing;

use Lencse\Rectum\Component\Web\Routing\Route;

class FastRoutePath
{

    /**
     * @var Route
     */
    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function __toString(): string
    {
        $result = $this->route->getPath();
        foreach ($this->route->getParameterFormats() as $param => $format) {
            /** @var string $result */
            $result = preg_replace("/\{($param)\}/", "{\$1:$format}", $result);
        }

        return $result;
    }
}
