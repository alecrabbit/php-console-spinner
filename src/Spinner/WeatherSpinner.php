<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Core\Spinner;

class WeatherSpinner extends Spinner
{
    protected const INTERVAL = 0.15;
    protected const FRAMES = Frames::WEATHER;
    protected const
        STYLES =
        [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR256 => Styles::DISABLED,
                    Juggler::COLOR => Styles::DISABLED,
                ],
        ];
}
