<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IStrSplitter;

use function mb_str_split;

final class StrSplitter implements IStrSplitter
{
    public static function split(string $s, ?int $length = null): array
    {
        $length = $length ?? 1;
        return mb_str_split($s, $length);
    }
}
