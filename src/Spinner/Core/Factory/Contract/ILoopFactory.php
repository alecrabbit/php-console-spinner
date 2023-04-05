<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;

interface ILoopFactory
{
    public function getLoop(): ILoopAdapter;

    public function registerAutoStart(): void;

    public function registerSignalHandlers(\Traversable $handlers): void;
}
