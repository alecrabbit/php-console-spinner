<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

final class Color
{
    private const COLORS = [
        196,
        196,
        202,
        202,
        208,
        208,
        214,
        214,
        220,
        220,
        226,
        226,
        190,
        190,
        154,
        154,
        118,
        118,
        82,
        82,
        46,
        46,
        47,
        47,
        48,
        48,
        49,
        49,
        50,
        50,
        51,
        51,
        45,
        45,
        39,
        39,
        33,
        33,
        27,
        27,
        56,
        56,
        57,
        57,
        93,
        93,
        129,
        129,
        165,
        165,
        201,
        201,
        200,
        200,
        199,
        199,
        198,
        198,
        197,
        197,
    ];

    private int $currentColorIdx = 0;
    private int $colorLen;

    public function __construct()
    {
        $this->colorLen = count(self::COLORS);
    }

    public function next(): string
    {
        if (++$this->currentColorIdx === $this->colorLen) {
            $this->currentColorIdx = 0;
        }
        return (string)self::COLORS[$this->currentColorIdx];
    }

}
