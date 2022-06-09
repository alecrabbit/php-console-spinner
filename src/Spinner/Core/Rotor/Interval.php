<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

final class Interval implements IInterval
{
    public function __construct(
        public readonly int|float $value,
    )
    {
    }

    public function toFloat(): float
    {
        return (float)$this->value;
    }
}


