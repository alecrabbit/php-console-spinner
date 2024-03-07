<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedLoopSetupFactory;
use AlecRabbit\Lib\Spinner\Contract\IMemoryReportPrinter;
use AlecRabbit\Lib\Spinner\Core\Loop\DecoratedLoopSetup;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;

final readonly class DecoratedLoopSetupFactory implements IDecoratedLoopSetupFactory, IInvokable
{
    public function __construct(
        private ILoopSetupFactory $loopSetupFactory,
        private IMemoryReportPrinter $memoryReportPrinter,
    ) {
    }

    public function __invoke(): ILoopSetup
    {
        return $this->create();
    }

    public function create(): ILoopSetup
    {
        $loopSetup = $this->loopSetupFactory->create();

        return new DecoratedLoopSetup(
            loopSetup: $loopSetup,
            memoryReportPrinter: $this->memoryReportPrinter,
        );
    }
}
