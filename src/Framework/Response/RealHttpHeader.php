<?php

namespace Lencse\Rectum\Framework\Response;

use Lencse\Rectum\Component\Response\HttpHeader;

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
