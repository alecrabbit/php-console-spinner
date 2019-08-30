<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Core\Spinner;

class SimpleSpinner extends Spinner
{
    protected const INTERVAL = 0.17;
    protected const FRAMES = Frames::SIMPLE;
    protected const
        STYLES =
        [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR => Styles::C_LIGHT_CYAN,
                ],
        ];
}
