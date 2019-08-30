<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Core\Spinner;

class CircleSpinner extends Spinner
{
    protected const INTERVAL = 0.17;
    protected const FRAMES = Frames::CIRCLES;
    protected const
        STYLES =
        [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR256 => Styles::C256_YELLOW_WHITE,
                    Juggler::COLOR => Styles::C_LIGHT_YELLOW,
                ],
        ];
}
