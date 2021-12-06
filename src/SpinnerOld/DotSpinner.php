<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld;

use AlecRabbit\SpinnerOld\Core\Contracts\Frames;
use AlecRabbit\SpinnerOld\Core\Contracts\Juggler;
use AlecRabbit\SpinnerOld\Core\Contracts\Styles;
use AlecRabbit\SpinnerOld\Core\Spinner;

class DotSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const FRAMES = Frames::DOT;
    protected const
        STYLES =
        [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR => Styles::C_LIGHT_CYAN,
                ],
        ];
}
