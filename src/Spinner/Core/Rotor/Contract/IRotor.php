<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor\Contract;

interface IRotor
{
    public function next(?IInterval $interval = null): string;

    public function getInterval(): ?IInterval;
}
