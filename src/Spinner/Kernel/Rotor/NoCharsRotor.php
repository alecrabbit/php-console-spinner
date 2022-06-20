<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Rotor;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\AStringRotor;

final class NoCharsRotor extends AStringRotor
{
    public function __construct()
    {
        // initialize with defaults
        parent::__construct();
    }

    public function next(): string
    {
        return C::EMPTY_STRING;
    }
}
