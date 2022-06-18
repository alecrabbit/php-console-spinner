<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor\Contract;

interface IRotor
{
    public function next(): string;

    public function getInterval(?IInterval $preferredInterval = null): ?IInterval;
}
