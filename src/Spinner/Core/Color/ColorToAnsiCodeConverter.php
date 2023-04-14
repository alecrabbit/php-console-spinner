<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core\Color;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Helper\Asserter;
use AlecRabbit\Spinner\Mixin\AnsiColorTableTrait;

final class ColorToAnsiCodeConverter implements IColorToAnsiCodeConverter
{
    use AnsiColorTableTrait;

    public function __construct(
        protected OptionStyleMode $styleMode,
    ) {
        self::assert($this);
    }

    protected static function assert(self $obj): void
    {
        if ($obj->styleMode === OptionStyleMode::NONE) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unsupported style mode "%s".',
                    $obj->styleMode->name,
                )
            );
        }
    }

    /** @inheritdoc */
    public function ansiCode(string $color): string
    {
        return
            match ($this->styleMode) {
                OptionStyleMode::ANSI4 => $this->convert4($color),
                OptionStyleMode::ANSI8 => $this->convert8($color),
                OptionStyleMode::ANSI24 => $this->convert24($color),
                default => throw new LogicException(
                    sprintf(
                        '%s::%s: Unable to convert "%s" to ansi code.',
                        OptionStyleMode::class,
                        $this->styleMode->name,
                        $color
                    )
                ),
            };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert4(int|string $color): string
    {
        if (is_int($color)) {
            return (string)$color;
        }
        return $this->convertFromHexToAnsiColorCode($color);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convertFromHexToAnsiColorCode(string $hexColor): string
    {
        $hexColor = str_replace('#', '', $hexColor);

        if (3 === strlen($hexColor)) {
            $hexColor = $hexColor[0] . $hexColor[0] . $hexColor[1] . $hexColor[1] . $hexColor[2] . $hexColor[2];
        }

        if (6 !== strlen($hexColor)) {
            throw new InvalidArgumentException(sprintf('Invalid "#%s" color.', $hexColor));
        }

        $color = hexdec($hexColor);

        $r = ($color >> 16) & 255;
        $g = ($color >> 8) & 255;
        $b = $color & 255;

        return
            match ($this->styleMode) {
                OptionStyleMode::ANSI4 => (string)$this->convertFromRGB($r, $g, $b),
                OptionStyleMode::ANSI8 => '8;5;' . ((string)$this->convertFromRGB($r, $g, $b)),
                OptionStyleMode::ANSI24 => sprintf('8;2;%d;%d;%d', $r, $g, $b),
                OptionStyleMode::NONE => throw new InvalidArgumentException(
                    sprintf(
                        'Hex color cannot be converted to %s.',
                        $this->styleMode->name
                    )
                ),
            };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convertFromRGB(int $r, int $g, int $b): int
    {
        return
            match ($this->styleMode) {
                OptionStyleMode::ANSI4 => $this->degradeHexColorToAnsi4($r, $g, $b),
                OptionStyleMode::ANSI8 => $this->degradeHexColorToAnsi8($r, $g, $b),
                default => throw new InvalidArgumentException(
                    sprintf(
                        'RGB cannot be converted to %s.',
                        $this->styleMode->name
                    )
                )
            };
    }

    protected function degradeHexColorToAnsi4(int $r, int $g, int $b): int
    {
        /** @psalm-suppress TypeDoesNotContainType */
        if (0 === round($this->getSaturation($r, $g, $b) / 50)) { // 0 === round(... - it is a hack
            return 0;
        }

        return (int)((round($b / 255) << 2) | (round($g / 255) << 1) | round($r / 255));
    }

    protected function getSaturation(int $r, int $g, int $b): int
    {
        $rf = $r / 255;
        $gf = $g / 255;
        $bf = $b / 255;
        $v = max($rf, $gf, $bf);

        if (0 === $diff = $v - min($rf, $gf, $bf)) {
            return 0;
        }

        return (int)($diff * 100 / $v);
    }

    /**
     * Inspired from https://github.com/ajalt/colormath/blob/e464e0da1b014976736cf97250063248fc77b8e7/colormath/src/commonMain/kotlin/com/github/ajalt/colormath/model/Ansi256.kt code (MIT license).
     */
    protected function degradeHexColorToAnsi8(int $r, int $g, int $b): int
    {
        if ($r === $g && $g === $b) {
            if ($r < 8) {
                return 16;
            }

            if ($r > 248) {
                return 231;
            }

            return (int)round(($r - 8) / 247 * 24) + 232;
        }

        return 16 +
            (36 * (int)round($r / 255 * 5)) +
            (6 * (int)round($g / 255 * 5)) +
            (int)round($b / 255 * 5);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert8(int|string $color): string
    {
        if (is_int($color)) {
            return '8;5;' . $color;
        }

        $index = Ansi8Color::getIndex($color);

        if ($index) {
            return '8;5;' . $index;
        }

        return $this->convertFromHexToAnsiColorCode($color);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert24(string $color): string
    {
        return $this->convertFromHexToAnsiColorCode($color);
    }

    public function isDisabled(): bool
    {
        return !$this->styleMode->isStylingEnabled();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertColor(int|string $color, OptionStyleMode $styleMode): void
    {
        match (true) {
            is_int($color) => Asserter::assertIntColor($color, $styleMode),
            is_string($color) => Asserter::assertHexStringColor($color),
        };
    }
}
