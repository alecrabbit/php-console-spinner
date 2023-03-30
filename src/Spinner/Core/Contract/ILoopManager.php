<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ILoopManager
{
    public function createLoop(): ILoopAdapter;
}
