<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class EarthSpinner extends Spinner
{
    protected const INTERVAL = 0.2;
    protected const FRAMES = Frames::EARTH;
    protected const
        STYLES =
        [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR => StylesInterface::C_LIGHT_CYAN,
                ],
        ];
}
