<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Symbols;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class ZodiacSpinner extends Spinner
{
    // protected const ERASING_SHIFT = 2;
    protected const INTERVAL = 0.25;
    protected const SYMBOLS = Symbols::ZODIAC;
    protected const
        STYLES =
        [
            StylesInterface::SPINNER_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::DISABLED,
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
        ];
}
