<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportSetupFactory;
use AlecRabbit\Lib\Spinner\Core\Loop\IMemoryReportLoopSetup;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;

final readonly class MemoryReportSetupFactory implements IMemoryReportSetupFactory, IInvokable
{
    public function __construct(
        private IMemoryReportLoopSetup $loopSetup,
        private ILoopProvider $loopProvider,
    ) {
    }

    public function __invoke(): IMemoryReportSetupFactory
    {
        dump(__METHOD__);
        if ($this->loopProvider->hasLoop()) {
            $this->loopSetup->setup($this->loopProvider->getLoop());
        }

        return $this;
    }
}
