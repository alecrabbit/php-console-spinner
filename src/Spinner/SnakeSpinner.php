<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class SnakeSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const FRAMES = Frames::SNAKE_VARIANT_0;
    protected const
        STYLES =
        [
            StylesInterface::FRAMES_STYLES =>
                [
                    StylesInterface::COLOR => StylesInterface::C_LIGHT_CYAN,
                ],
        ];
}
