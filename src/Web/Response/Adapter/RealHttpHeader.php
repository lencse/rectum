<?php

namespace Lencse\Rectum\Web\Response\Adapter;

use Lencse\Rectum\Web\Response\Component\HttpHeader;

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
