<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedDriverLinkerFactory;
use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportSetupFactory;
use AlecRabbit\Lib\Spinner\Contract\IDriverInfoPrinter;
use AlecRabbit\Lib\Spinner\Core\DecoratedDriverLinker;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Driver\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;

final readonly class DecoratedDriverLinkerFactory implements IDecoratedDriverLinkerFactory, IInvokable
{
    public function __construct(
        private IDriverLinkerFactory $driverLinkerFactory,
        private IDriverInfoPrinter $infoPrinter,
        private ILoopProvider $loopProvider,
        private IMemoryReportSetupFactory $loopSetupFactory,
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
            $this->loopProvider,
            $this->loopSetupFactory,
        );
    }
}
