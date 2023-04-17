<?php

declare(strict_types=1);

// 25.03.23

namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\A\AAnsiColor;
use AlecRabbit\Spinner\Core\Color\Mixin\Ansi8ColorTableTrait;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;

final class Ansi4Color extends AAnsiColor
{
    use Ansi8ColorTableTrait;

    /** @var array<string,int>|null */
    protected static ?array $colors = null;

    /** @return array<string,int> */
    protected static function getColors(): array
    {
        if (self::$colors === null) {
            self::$colors = array_flip(array_slice(self::COLORS, 0, 16));
        }
        return self::$colors;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function assertIndex(int $index): void
    {
        Asserter::assertIntColor($index, OptionStyleMode::ANSI4);
    }
}
