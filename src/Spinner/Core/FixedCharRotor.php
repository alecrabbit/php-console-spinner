<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ACharRotor;
use AlecRabbit\Spinner\Core\Contract\IRotor;

final class FixedCharRotor extends ACharRotor implements IRotor
{
    public function next(): string
    {
        return '';
    }
}
