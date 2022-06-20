<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Rotor\Contract;

interface IRotor
{
    public function next(): string;

    public function getInterval(?WIInterval $preferredInterval = null): ?WIInterval;
}
