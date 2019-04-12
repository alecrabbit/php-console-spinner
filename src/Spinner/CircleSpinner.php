<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contracts\SpinnerSymbols;
use AlecRabbit\Spinner\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class CircleSpinner extends Spinner
{
    protected const ERASING_SHIFT = 1;
    protected const INTERVAL = 0.17;
    protected const SYMBOLS = SpinnerSymbols::CIRCLES;
    protected const
        NEW_STYLES =
        [
            StylesInterface::SPINNER_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::C256_YELLOW_WHITE,
                    StylesInterface::COLOR => StylesInterface::C_LIGHT_YELLOW,
                ],
        ];

}
