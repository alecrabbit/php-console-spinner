<?php

declare(strict_types=1);

// 17.02.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IObserver;

interface IDriverLinker extends IObserver
{
    public function link(IDriver $driver): void;
}
