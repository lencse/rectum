<?php

namespace Lencse\Rectum\Component\Web\Routing;

interface RouteHandlingConfig
{

    public function getRequestProcessorClass(): string;

    public function getDataTransformerClass(): string;
}
