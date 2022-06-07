<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\AStyleRotor;
use AlecRabbit\Spinner\Core\Contract\IRotor;

final class NoStyleRotor extends AStyleRotor
{
    public function next(float|int|null $interval = null): string
    {
        return '';
    }
}
