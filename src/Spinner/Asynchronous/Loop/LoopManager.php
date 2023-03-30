<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop;

use AlecRabbit\Spinner\Core\A\AManager;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopManager;

final class LoopManager extends AManager implements ILoopManager
{
    public function createLoop(): ILoopAdapter
    {
        // TODO: Implement createLoop() method.
    }
}
