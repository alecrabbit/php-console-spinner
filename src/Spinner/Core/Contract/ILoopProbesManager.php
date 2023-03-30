<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ILoopProbesManager
{
    public function createLoop(): ILoopAdapter;
}
