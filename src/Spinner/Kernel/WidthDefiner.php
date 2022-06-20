<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Kernel;

use AlecRabbit\Spinner\Kernel\Contract\IWidthDefiner;

use function is_int;
use function mb_strlen;

final class WidthDefiner implements IWidthDefiner
{
    public static function define(int|string ...$elements): int
    {
        $width = 0;
        foreach ($elements as $element) {
            $width += is_int($element) ? $element : self::defineWidth($element);
        }
        return $width;
    }

    private static function defineWidth(string $element): int
    {
        return mb_strlen($element);
    }
}
