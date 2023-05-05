<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color\A;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\Mixin\Ansi8ColorTableTrait;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class AAnsiColor
{
    use Ansi8ColorTableTrait;

    /**
     * @throws InvalidArgumentException
     */
    public static function getIndex(string $hex): ?int
    {
        static::assertHexStringColor($hex);
        return static::getColors()[$hex] ?? null;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function assertHexStringColor(string $hex): void
    {
        Asserter::assertHexStringColor($hex);
    }

    abstract protected static function getColors(): array;

    /**
     * @throws InvalidArgumentException
     */
    public static function getHexColor(int $index): string
    {
        static::assertIndex($index);
        return self::COLORS[$index];
    }

    /**
     * @throws InvalidArgumentException
     */
    abstract protected static function assertIndex(int $index): void;
}
