<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class MoonSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const FRAMES = Frames::MOON;
    protected const
        STYLES =
        [
            StylesInterface::FRAMES_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::DISABLED,
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
        ];
}
