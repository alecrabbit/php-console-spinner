<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Style;

use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;

final class Rainbow extends AStylePattern
{
    protected const UPDATE_INTERVAL = 400;

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
}