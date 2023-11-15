<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Helper\Contract;

interface IBytesFormatter
{
    public function format(int $bytes): string;
}
