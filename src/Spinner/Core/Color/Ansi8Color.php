<?php
declare(strict_types=1);
// 25.03.23
namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\StyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Spinner\Mixin\AnsiColorTableTrait;

final class Ansi8Color
{
    use AnsiColorTableTrait;

    private static ?array $flipped = null;

    public static function getIndex(string $hex): ?int
    {
        return self::getFlipped()[$hex] ?? null;
    }

    private static function getFlipped(): array
    {
        if (null === self::$flipped) {
            self::$flipped = array_flip(self::COLORS);
        }
        return self::$flipped;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function getHexColor(int $index): string
    {
        self::assertIndex($index);
        return self::COLORS[$index];
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertIndex(int $index): void
    {
        Asserter::assertIntColor($index, StyleMode::ANSI8);
    }
}