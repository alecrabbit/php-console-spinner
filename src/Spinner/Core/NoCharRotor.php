<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ACharRotor;
use AlecRabbit\Spinner\Core\Contract\IRotor;

final class NoCharRotor extends ACharRotor
{
    public function next(float|int|null $interval = null): string
    {
        return '';
    }
}
