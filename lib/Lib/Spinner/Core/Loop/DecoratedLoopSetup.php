<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core\Loop;

use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportSetupFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;

final readonly class DecoratedLoopSetup implements ILoopSetup
{
    public function __construct(
        private ILoopSetup $loopSetup,
    ) {
    }

    public function setup(ILoop $loop): void
    {
        $this->loopSetup->setup($loop);
    }
}
