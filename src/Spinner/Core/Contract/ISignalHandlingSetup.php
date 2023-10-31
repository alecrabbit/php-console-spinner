<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ISignalHandlingSetup
{
    public function setup(IDriver $driver): void;
}
