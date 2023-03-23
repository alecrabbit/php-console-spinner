<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

use function strlen;

enum ColorMode: int
{
    protected const COLOR_TABLE = [
        0 => '#000000',
        1 => '#800000',
        2 => '#008000',
        3 => '#808000',
        4 => '#000080',
        5 => '#800080',
        6 => '#008080',
        7 => '#c0c0c0',
        8 => '#808080',
        9 => '#ff0000',
        10 => '#00ff00',
        11 => '#ffff00',
        12 => '#0000ff',
        13 => '#ff00ff',
        14 => '#00ffff',
        15 => '#ffffff',
        16 => '#000000',
        17 => '#00005f',
        18 => '#000087',
        19 => '#0000af',
        20 => '#0000d7',
        21 => '#0000ff',
        22 => '#005f00',
        23 => '#005f5f',
        24 => '#005f87',
        25 => '#005faf',
        26 => '#005fd7',
        27 => '#005fff',
        28 => '#008700',
        29 => '#00875f',
        30 => '#008787',
        31 => '#0087af',
        32 => '#0087d7',
        33 => '#0087ff',
        34 => '#00af00',
        35 => '#00af5f',
        36 => '#00af87',
        37 => '#00afaf',
        38 => '#00afd7',
        39 => '#00afff',
        40 => '#00d700',
        41 => '#00d75f',
        42 => '#00d787',
        43 => '#00d7af',
        44 => '#00d7d7',
        45 => '#00d7ff',
        46 => '#00ff00',
        47 => '#00ff5f',
        48 => '#00ff87',
        49 => '#00ffaf',
        50 => '#00ffd7',
        51 => '#00ffff',
        52 => '#5f0000',
        53 => '#5f005f',
        54 => '#5f0087',
        55 => '#5f00af',
        56 => '#5f00d7',
        57 => '#5f00ff',
        58 => '#5f5f00',
        59 => '#5f5f5f',
        60 => '#5f5f87',
        61 => '#5f5faf',
        62 => '#5f5fd7',
        63 => '#5f5fff',
        64 => '#5f8700',
        65 => '#5f875f',
        66 => '#5f8787',
        67 => '#5f87af',
        68 => '#5f87d7',
        69 => '#5f87ff',
        70 => '#5faf00',
        71 => '#5faf5f',
        72 => '#5faf87',
        73 => '#5fafaf',
        74 => '#5fafd7',
        75 => '#5fafff',
        76 => '#5fd700',
        77 => '#5fd75f',
        78 => '#5fd787',
        79 => '#5fd7af',
        80 => '#5fd7d7',
        81 => '#5fd7ff',
        82 => '#5fff00',
        83 => '#5fff5f',
        84 => '#5fff87',
        85 => '#5fffaf',
        86 => '#5fffd7',
        87 => '#5fffff',
        88 => '#870000',
        89 => '#87005f',
        90 => '#870087',
        91 => '#8700af',
        92 => '#8700d7',
        93 => '#8700ff',
        94 => '#875f00',
        95 => '#875f5f',
        96 => '#875f87',
        97 => '#875faf',
        98 => '#875fd7',
        99 => '#875fff',
        100 => '#878700',
        101 => '#87875f',
        102 => '#878787',
        103 => '#8787af',
        104 => '#8787d7',
        105 => '#8787ff',
        106 => '#87af00',
        107 => '#87af5f',
        108 => '#87af87',
        109 => '#87afaf',
        110 => '#87afd7',
        111 => '#87afff',
        112 => '#87d700',
        113 => '#87d75f',
        114 => '#87d787',
        115 => '#87d7af',
        116 => '#87d7d7',
        117 => '#87d7ff',
        118 => '#87ff00',
        119 => '#87ff5f',
        120 => '#87ff87',
        121 => '#87ffaf',
        122 => '#87ffd7',
        123 => '#87ffff',
        124 => '#af0000',
        125 => '#af005f',
        126 => '#af0087',
        127 => '#af00af',
        128 => '#af00d7',
        129 => '#af00ff',
        130 => '#af5f00',
        131 => '#af5f5f',
        132 => '#af5f87',
        133 => '#af5faf',
        134 => '#af5fd7',
        135 => '#af5fff',
        136 => '#af8700',
        137 => '#af875f',
        138 => '#af8787',
        139 => '#af87af',
        140 => '#af87d7',
        141 => '#af87ff',
        142 => '#afaf00',
        143 => '#afaf5f',
        144 => '#afaf87',
        145 => '#afafaf',
        146 => '#afafd7',
        147 => '#afafff',
        148 => '#afd700',
        149 => '#afd75f',
        150 => '#afd787',
        151 => '#afd7af',
        152 => '#afd7d7',
        153 => '#afd7ff',
        154 => '#afff00',
        155 => '#afff5f',
        156 => '#afff87',
        157 => '#afffaf',
        158 => '#afffd7',
        159 => '#afffff',
        160 => '#d70000',
        161 => '#d7005f',
        162 => '#d70087',
        163 => '#d700af',
        164 => '#d700d7',
        165 => '#d700ff',
        166 => '#d75f00',
        167 => '#d75f5f',
        168 => '#d75f87',
        169 => '#d75faf',
        170 => '#d75fd7',
        171 => '#d75fff',
        172 => '#d78700',
        173 => '#d7875f',
        174 => '#d78787',
        175 => '#d787af',
        176 => '#d787d7',
        177 => '#d787ff',
        178 => '#d7af00',
        179 => '#d7af5f',
        180 => '#d7af87',
        181 => '#d7afaf',
        182 => '#d7afd7',
        183 => '#d7afff',
        184 => '#d7d700',
        185 => '#d7d75f',
        186 => '#d7d787',
        187 => '#d7d7af',
        188 => '#d7d7d7',
        189 => '#d7d7ff',
        190 => '#d7ff00',
        191 => '#d7ff5f',
        192 => '#d7ff87',
        193 => '#d7ffaf',
        194 => '#d7ffd7',
        195 => '#d7ffff',
        196 => '#ff0000',
        197 => '#ff005f',
        198 => '#ff0087',
        199 => '#ff00af',
        200 => '#ff00d7',
        201 => '#ff00ff',
        202 => '#ff5f00',
        203 => '#ff5f5f',
        204 => '#ff5f87',
        205 => '#ff5faf',
        206 => '#ff5fd7',
        207 => '#ff5fff',
        208 => '#ff8700',
        209 => '#ff875f',
        210 => '#ff8787',
        211 => '#ff87af',
        212 => '#ff87d7',
        213 => '#ff87ff',
        214 => '#ffaf00',
        215 => '#ffaf5f',
        216 => '#ffaf87',
        217 => '#ffafaf',
        218 => '#ffafd7',
        219 => '#ffafff',
        220 => '#ffd700',
        221 => '#ffd75f',
        222 => '#ffd787',
        223 => '#ffd7af',
        224 => '#ffd7d7',
        225 => '#ffd7ff',
        226 => '#ffff00',
        227 => '#ffff5f',
        228 => '#ffff87',
        229 => '#ffffaf',
        230 => '#ffffd7',
        231 => '#ffffff',
        232 => '#080808',
        233 => '#121212',
        234 => '#1c1c1c',
        235 => '#262626',
        236 => '#303030',
        237 => '#3a3a3a',
        238 => '#444444',
        239 => '#4e4e4e',
        240 => '#585858',
        241 => '#626262',
        242 => '#6c6c6c',
        243 => '#767676',
        244 => '#808080',
        245 => '#8a8a8a',
        246 => '#949494',
        247 => '#9e9e9e',
        248 => '#a8a8a8',
        249 => '#b2b2b2',
        250 => '#bcbcbc',
        251 => '#c6c6c6',
        252 => '#d0d0d0',
        253 => '#dadada',
        254 => '#e4e4e4',
        255 => '#eeeeee',
    ];

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

    protected function hslToRgb(int $hue, float $s = 1.0, float $l = 0.5): string
    {
        $h = $hue / 360;
        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h * 6, 2) - 1));
        $m = $l - $c / 2;

        $r = 0;
        $g = 0;
        $b = 0;

        match (true) {
            $h < 1 / 6 => [$r, $g] = [$c, $x],
            $h < 2 / 6 => [$r, $g] = [$x, $c],
            $h < 3 / 6 => [$g, $b] = [$c, $x],
            $h < 4 / 6 => [$g, $b] = [$x, $c],
            $h < 5 / 6 => [$r, $b] = [$x, $c],
            default => [$r, $b] = [$c, $x],
        };

        $r = ($r + $m) * 255;
        $g = ($g + $m) * 255;
        $b = ($b + $m) * 255;

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
