<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;

class ExtendedSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const FRAMES = ['1', '2', '3', '4',];
    protected const
        STYLES =
        [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR256 => StylesInterface::DISABLED,
                    Juggler::COLOR =>  [1, 2, 3, 4],
                ],
        ];
}
