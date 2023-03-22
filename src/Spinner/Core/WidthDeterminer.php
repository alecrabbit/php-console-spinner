<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Mixin\NoInstanceTrait;
use Closure;

use function AlecRabbit\WCWidth\wcswidth;
use function mb_strlen;
use function strlen;

final class WidthDeterminer
{
    use NoInstanceTrait;

    private static ?Closure $determiner = null;

    public static function determine(string $string): int
    {
        if (null === self::$determiner) {
            self::$determiner = self::createDeterminer();
        }
        return (int)(self::$determiner)($string);
    }

    /**
     * @codeCoverageIgnore
     */
    private static function createDeterminer(): Closure
    {
        if (function_exists('\AlecRabbit\WCWidth\wcswidth')) {
            return static function (string $string): int {
                return wcswidth($string);
            };
        }
        if (function_exists('\mb_strlen')) {
            return static function (string $string): int {
                return mb_strlen($string);
            };
        }
        return static function (string $string): int {
            return strlen($string);
        };
    }

    public static function overrideDeterminer(Closure $determiner): void
    {
        self::$determiner = $determiner;
    }

    public static function reset(): void
    {
        self::$determiner = null;
    }
}
