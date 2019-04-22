<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class SnakeSpinner extends Spinner
{
    protected const ERASING_SHIFT = 1;
    protected const INTERVAL = 0.1;
    protected const SYMBOLS = SpinnerSymbols::SNAKE_VARIANT_0;
    protected const
        STYLES =
        [
            StylesInterface::SPINNER_STYLES =>
                [
                    StylesInterface::COLOR => StylesInterface::C_LIGHT_CYAN,
                ],
        ];
}
