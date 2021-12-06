<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld;

use AlecRabbit\SpinnerOld\Core\Contracts\Frames;
use AlecRabbit\SpinnerOld\Core\Contracts\Juggler;
use AlecRabbit\SpinnerOld\Core\Contracts\Styles;
use AlecRabbit\SpinnerOld\Core\Spinner;

class EarthSpinner extends Spinner
{
    protected const INTERVAL = 0.2;
    protected const FRAMES = Frames::EARTH;
    protected const
        STYLES =
        [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR => Styles::C_LIGHT_CYAN,
                ],
        ];
}
