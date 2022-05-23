<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\AColorRotor;
use AlecRabbit\Spinner\Core\Contract\IRotor;

final class FixedColorRotor extends AColorRotor implements IRotor
{
    public function next(): string
    {
        return '';
    }
}
