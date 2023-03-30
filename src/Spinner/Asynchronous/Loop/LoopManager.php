<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop;

use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopManager;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;

final class LoopManager implements ILoopManager
{
    public function __construct(
        protected ILoopProbeFactory $loopProbeFactory,
    ) {
    }

    public function createLoop(): ILoopAdapter
    {
        return $this->getLoopProbe()->createLoop();
    }

    protected function getLoopProbe(): ILoopProbe
    {
        return $this->loopProbeFactory->getProbe();
    }
}
