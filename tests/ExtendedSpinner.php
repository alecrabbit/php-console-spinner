<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Styling;

class ExtendedSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const SYMBOLS = ['1', '2', '3', '4',];
    protected const
        STYLES =
        [
            Styling::COLOR256_SPINNER_STYLES => null,
            Styling::COLOR_SPINNER_STYLES => [1, 2, 3, 4],
        ];
}
