<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedDriverLinkerFactory;
use AlecRabbit\Lib\Spinner\Contract\IDriverInfoPrinter;
use AlecRabbit\Lib\Spinner\Core\DecoratedDriverLinker;
use AlecRabbit\Lib\Spinner\Core\Loop\IMemoryReportLoopSetup;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Driver\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;

final readonly class DecoratedDriverLinkerFactory implements IDecoratedDriverLinkerFactory, IInvokable
{
    public function __construct(
        private IDriverLinkerFactory $driverLinkerFactory,
        private IDriverInfoPrinter $infoPrinter,
        private IMemoryReportLoopSetup $loopSetup,
    ) {
    }

    public function __invoke(): IDriverLinker
    {
        return $this->create();
    }

    public function create(): IDriverLinker
    {
        $linker = $this->driverLinkerFactory->create();

        if ($linker instanceof DummyDriverLinker) {
            return $linker;
        }

        return new DecoratedDriverLinker(
            $linker,
            $this->infoPrinter,
            $this->loopSetup,
        );
    }
}
