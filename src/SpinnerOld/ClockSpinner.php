<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld;

use AlecRabbit\SpinnerOld\Core\Contracts\Frames;
use AlecRabbit\SpinnerOld\Core\Contracts\Juggler;
use AlecRabbit\SpinnerOld\Core\Contracts\Styles;
use AlecRabbit\SpinnerOld\Core\Spinner;

class ClockSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const FRAMES = Frames::CLOCK;
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
