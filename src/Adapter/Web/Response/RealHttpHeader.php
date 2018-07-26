<?php

namespace Lencse\Rectum\Adapter\Web\Response;

use Lencse\Rectum\Component\Web\Response\HttpHeader;

/**
 * @codeCoverageIgnore
 */
class RealHttpHeader implements HttpHeader
{

    public function sendHeader(string $header): void
    {
        header($header);
    }
}
