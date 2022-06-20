<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Contract;

use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IRevolveWiggler;

interface IBaseSpinner
{
    public function spin(): void;

    public function initialize(): void;

    public function interrupt(): void;

    public function finalize(): void;

    public function erase(): void;

    public function pause(): void;

    public function resume(): void;

    public function wrap(callable $callback, ...$args): void;
}
