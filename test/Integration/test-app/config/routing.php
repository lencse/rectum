<?php

namespace AppConfig;

use Lencse\Rectum\Component\Web\Http\HttpMethod;
use Lencse\Rectum\Framework\Web\Routing\Configuration\RoutingConfig;
use TestApp\Handler\BasicHandler;

return new class implements RoutingConfig
{

    public function routes(): array
    {
        return [
            [HttpMethod::get(), '/', BasicHandler::class],
        ];
    }
};
