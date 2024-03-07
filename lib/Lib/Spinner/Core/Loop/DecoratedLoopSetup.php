<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;

final readonly class DecoratedLoopSetup implements ILoopSetup
{
    public function __construct(
        private ILoopSetup $loopSetup,
        private IMemoryReportLoopSetup $memoryReportLoopSetup,
    ) {
    }

    public function setup(ILoop $loop): void
    {
        dump(__METHOD__);
        $this->loopSetup->setup($loop);
        $this->memoryReportLoopSetup->setup($loop);
    }
}
