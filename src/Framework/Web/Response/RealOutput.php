<?php

namespace Lencse\Rectum\Framework\Web\Response;

use Lencse\Rectum\Component\Web\Response\Output;

class RealOutput implements Output
{

    public function print(string $content): void
    {
        echo $content;
    }
}
