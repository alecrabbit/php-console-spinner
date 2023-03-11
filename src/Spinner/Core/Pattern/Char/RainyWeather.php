<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\APattern;

final class RainyWeather extends APattern
{
    protected const UPDATE_INTERVAL = 100;

    public function getPattern(): iterable
    {
        return [
            '🌤 ',
            '🌤 ',
            '🌤 ',
            '🌥 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌥 ',
            '🌤 ',
            '🌤 ',
            '🌤 ',
        ];
    }
}