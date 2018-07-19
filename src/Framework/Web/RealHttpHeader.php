<?php

namespace Lencse\Rectum\Framework\Web;

use Lencse\Rectum\Component\Web\HttpHeader;

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
