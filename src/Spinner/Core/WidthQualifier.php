<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IWidthQualifier;

use function is_int;
use function mb_strlen;

final class WidthQualifier implements IWidthQualifier
{
    public static function qualify(int|string ...$elements): int
    {
        $width = 0;
        foreach ($elements as $element) {
            $width += is_int($element) ? $element : mb_strlen($element);
        }
        return $width;
    }
}
