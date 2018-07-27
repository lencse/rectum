<?php

namespace Lencse\Rectum\Component\Web\Response;

interface Output
{
    public function print(string $content): void;
}
