<?php

namespace Lencse\Rectum\Framework\Response;

use Lencse\Rectum\Component\Response\Output;

class RealOutput implements Output
{

    public function print(string $content): void
    {
        echo $content;
    }
}
