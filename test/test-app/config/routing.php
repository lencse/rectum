<?php

namespace AppConfig;

use Lencse\Rectum\Web\Http\Component\HttpMethod;
use Lencse\Rectum\Web\Routing\Configuration\RoutingConfig;
use TestApp\Handler\HelloHandler;
use TestApp\Handler\OkHandler;

return new class() implements RoutingConfig {
    public function routes(): array
    {
        return [
            [HttpMethod::get(), '/', OkHandler::class],
            [HttpMethod::get(), '/hello/{name}', HelloHandler::class, ['name' => '[a-zA-Z]+']],
        ];
    }
};
