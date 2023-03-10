<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Terminal\ColorMode;

final class ProceduralRainbow extends AStylePattern
{
    protected const UPDATE_INTERVAL = 500;

    public function getColorMode(): ColorMode
    {
        return ColorMode::ANSI8;
    }

    public function getPattern(): iterable|IProcedure
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
}