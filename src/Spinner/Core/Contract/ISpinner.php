<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;

interface ISpinner
{
    public function __construct(IConfig $config);

    public function getInterval(): IInterval;

    public function spin(): void;

    public function initialize(): void;

    public function interrupt(): void;

    public function finalize(): void;

    public function erase(): void;

    public function pause(): void;

    public function resume(): void;

    public function wrap(callable $callback, ...$args): void;

    public function spinner(IRevolveWiggler|string|null $wiggler): void;

    public function message(IMessageWiggler|string|null $wiggler): void;

    public function progress(IProgressWiggler|float|null $wiggler): void;
}
