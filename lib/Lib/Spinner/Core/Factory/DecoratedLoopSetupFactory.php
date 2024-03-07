<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedLoopSetupFactory;
use AlecRabbit\Lib\Spinner\Core\Loop\DecoratedLoopSetup;
use AlecRabbit\Lib\Spinner\Core\Loop\IMemoryReportLoopSetup;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;

final readonly class DecoratedLoopSetupFactory implements IDecoratedLoopSetupFactory, IInvokable
{
    public function __construct(
        private ILoopSetupFactory $loopSetupFactory,
        private IMemoryReportLoopSetup $memoryReportLoopSetup,
    ) {
    }

    public function __invoke(): ILoopSetup
    {
        return $this->create();
    }

    public function create(): ILoopSetup
    {
        return new DecoratedLoopSetup(
            loopSetup: $this->loopSetupFactory->create(),
            memoryReportLoopSetup: $this->memoryReportLoopSetup,
        );
    }
}
