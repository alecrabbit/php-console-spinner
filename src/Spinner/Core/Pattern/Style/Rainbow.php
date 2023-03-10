<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;
use AlecRabbit\Spinner\Core\Terminal\ColorMode;

final class Rainbow extends AStylePattern
{
    public function getColorMode(): ColorMode
    {
        return ColorMode::ANSI8;
    }

    public function getPattern(): iterable
    {
        return [
            196,
            202,
            208,
            214,
            220,
            226,
            190,
            154,
            118,
            82,
            46,
            47,
            48,
            49,
            50,
            51,
            45,
            39,
            33,
            27,
            56,
            57,
            93,
            129,
            165,
            201,
            200,
            199,
            198,
            197,
        ];
    }

    public function getInterval(): IInterval
    {
        return new Interval(360);
    }
}