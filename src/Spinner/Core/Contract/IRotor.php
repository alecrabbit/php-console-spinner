<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IRotor
{
    public function next(float|int|null $interval = null): string;
}
