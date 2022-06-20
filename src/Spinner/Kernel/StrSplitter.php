<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Kernel;

use AlecRabbit\Spinner\Kernel\Contract\IStrSplitter;

final class StrSplitter implements IStrSplitter
{

    public static function split(string $s): array
    {
        return mb_str_split($s);
    }
}
