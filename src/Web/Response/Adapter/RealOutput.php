<?php

namespace Lencse\Rectum\Web\Response\Adapter;

use Lencse\Rectum\Web\Response\Component\Output;

class RealOutput implements Output
{
    public function print(string $content): void
    {
        echo $content;
    }
}
