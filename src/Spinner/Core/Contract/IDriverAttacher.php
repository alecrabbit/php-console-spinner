<?php

declare(strict_types=1);

// 17.02.23

namespace AlecRabbit\Spinner\Core\Contract;

interface IDriverAttacher
{
    public function attach(IDriver $driver): void;
}
