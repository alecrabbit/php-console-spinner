<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Rotor\Contract\AStringRotor;

final class NoCharsRotor extends AStringRotor
{
    public function __construct()
    {
        // initialize with defaults
        parent::__construct();
    }

    public function next(float|int|null $interval = null): string
    {
        return C::EMPTY_STRING;
    }
}
