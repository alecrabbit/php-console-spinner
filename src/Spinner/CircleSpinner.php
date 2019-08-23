<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\AbstractSpinner;

class CircleSpinner extends AbstractSpinner
{
    protected const INTERVAL = 0.17;
    protected const FRAMES = Frames::CIRCLES;
    protected const
        STYLES =
        [
            StylesInterface::SPINNER_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::C256_YELLOW_WHITE,
                    StylesInterface::COLOR => StylesInterface::C_LIGHT_YELLOW,
                ],
        ];
}
