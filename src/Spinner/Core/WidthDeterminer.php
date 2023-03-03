<?php

declare(strict_types=1);
// 02.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Mixin\NoInstanceTrait;
use Closure;

use function AlecRabbit\WCWidth\wcswidth;
use function mb_strlen;

/** @internal */
final class WidthDeterminer
{
    use NoInstanceTrait;

    private static ?Closure $determiner = null;

    public static function determine(string $string): int
    {
        if (null === self::$determiner) {
            self::$determiner = self::createDeterminer();
        }
        return (self::$determiner)($string);
    }

    private static function createDeterminer(): Closure
    {
        if (function_exists('\AlecRabbit\WCWidth\wcswidth')) {
            return static function (string $string): int {
                return wcswidth($string);
            };
        }
        return static function (string $string): int {
            return mb_strlen($string);
        };
    }
}