<?php

namespace Lencse\Rectum\Component\Response;

interface Output
{

    public function print(string $content): void;
}
