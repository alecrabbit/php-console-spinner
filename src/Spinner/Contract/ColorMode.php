<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

use function strlen;

enum ColorMode: int
{
    protected const COLOR_TABLE = IColorConverter::COLOR_TABLE;

    case NONE = 0;
    case ANSI4 = 16;
    case ANSI8 = 256;
    case ANSI24 = 65535;

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function ansiCode(int|string $color): string
    {
        $this->assertColor($color);

        $color24 = (string)$color;

        return match ($this) {
            self::ANSI4 => $this->convert4($color),
            self::ANSI8 => $this->convert8($color),
            self::ANSI24 => $this->convert24($color24),
            default => throw new LogicException(
                sprintf(
                    '%s::%s: Unable to convert "%s" to ansi code.',
                    self::class,
                    $this->name,
                    $color
                )
            ),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertColor(int|string $color): void
    {
        match (true) {
            is_int($color) => $this->assertIntColor($color),
            is_string($color) => $this->assertStringColor($color),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertIntColor(int $color): void
    {
        match (true) {
            0 > $color => throw new InvalidArgumentException(
                sprintf(
                    'Value should be positive integer, %d given.',
                    $color
                )
            ),
            self::ANSI24->name === $this->name => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode rendering from int is not allowed.',
                    self::class,
                    self::ANSI24->name
                )
            ),
            self::ANSI8->name === $this->name && 255 < $color => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode value should be in range 0..255, %d given.',
                    self::class,
                    self::ANSI8->name,
                    $color
                )
            ),
            self::ANSI4->name === $this->name && 16 < $color => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s color mode value should be in range 0..15, %d given.',
                    self::class,
                    self::ANSI4->name,
                    $color
                )
            ),
            default => null,
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assertStringColor(string $entry): void
    {
        $strlen = strlen($entry);
        match (true) {
            0 === $strlen => throw new InvalidArgumentException(
                'Value should not be empty string.'
            ),
            !str_starts_with($entry, '#') => throw new InvalidArgumentException(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. No "#" found.',
                    $entry
                )
            ),
            4 !== $strlen && 7 !== $strlen => throw new InvalidArgumentException(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. Length: %d.',
                    $entry,
                    $strlen
                )
            ),
            default => null,
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
    private function convertFromHexToAnsiColorCode(string $hexColor): string
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

        return match ($this) {
            self::ANSI4 => (string)$this->convertFromRGB($r, $g, $b),
            self::ANSI8 => '8;5;' . ((string)$this->convertFromRGB($r, $g, $b)),
            self::ANSI24 => sprintf('8;2;%d;%d;%d', $r, $g, $b),
            self::NONE => throw new InvalidArgumentException('Hex color cannot be converted to NONE.'),
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    private function convertFromRGB(int $r, int $g, int $b): int
    {
        return match ($this) {
            self::ANSI4 => $this->degradeHexColorToAnsi4($r, $g, $b),
            self::ANSI8 => $this->degradeHexColorToAnsi8($r, $g, $b),
            default => throw new InvalidArgumentException("RGB cannot be converted to {$this->name}.")
        };
    }

    private function degradeHexColorToAnsi4(int $r, int $g, int $b): int
    {
        /** @psalm-suppress TypeDoesNotContainType */
        if (0 === round($this->getSaturation($r, $g, $b) / 50)) {
            return 0;
        }

        return (int)((round($b / 255) << 2) | (round($g / 255) << 1) | round($r / 255));
    }

    private function getSaturation(int $r, int $g, int $b): int
    {
        $r = $r / 255;
        $g = $g / 255;
        $b = $b / 255;
        $v = max($r, $g, $b);

        if (0 === $diff = $v - min($r, $g, $b)) {
            return 0;
        }

        return (int)((int)$diff * 100 / $v);
    }

    /**
     * Inspired from https://github.com/ajalt/colormath/blob/e464e0da1b014976736cf97250063248fc77b8e7/colormath/src/commonMain/kotlin/com/github/ajalt/colormath/model/Ansi256.kt code (MIT license).
     */
    private function degradeHexColorToAnsi8(int $r, int $g, int $b): int
    {
        if ($r === $g && $g === $b) {
            if ($r < 8) {
                return 16;
            }

            if ($r > 248) {
                return 231;
            }

            return (int)round(($r - 8) / 247 * 24) + 232;
        } else {
            return 16 +
                (36 * (int)round($r / 255 * 5)) +
                (6 * (int)round($g / 255 * 5)) +
                (int)round($b / 255 * 5);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert8(int|string $color): string
    {
        if (is_int($color)) {
            return '8;5;' . $color;
        }

        /** @var null|array<int, string> $colors8 */
        static $colors8 = null;

        if (null === $colors8) {
            $colors8 = array_slice(self::COLOR_TABLE, 16, preserve_keys: true);
        }

        /** @var int|false $result */
        $result =
            // non-optimal code, but it's not a bottleneck
            array_search(
                $color,
                $colors8,
                true
            );


        if (false === $result) {
            return $this->convertFromHexToAnsiColorCode($color);
        }

        return '8;5;' . (string)$result;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function convert24(string $color): string
    {
        return $this->convertFromHexToAnsiColorCode($color);
    }

    public function lowest(self $other): self
    {
        if ($this->value <= $other->value) {
            return $this;
        }
        return $other;
    }


}
