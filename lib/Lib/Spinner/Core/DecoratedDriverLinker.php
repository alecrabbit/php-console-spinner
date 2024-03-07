<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core;

use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportLoopSetupFactory;
use AlecRabbit\Lib\Spinner\Contract\IDriverInfoPrinter;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;

/**
 * This class is a decorator for the DriverLinker class.
 * It writes the current driver interval to the output during 'link' and 'update' method calls.
 */
final readonly class DecoratedDriverLinker implements IDriverLinker
{
    public function __construct(
        private IDriverLinker $linker,
        private IDriverInfoPrinter $infoPrinter,
        private ILoopProvider $loopProvider,
        private IMemoryReportLoopSetupFactory $loopSetupFactory,
    ) {
    }

    public function link(IDriver $driver): void
    {
        // this depends on the implementation of the DriverLinker::link() method

        $driver->attach($this); // setting $this as an observer

        $this->memoryReportSetup($driver);

        try {
            // Observer can not be overwritten so `attach()` will throw and should
            // be the last line in the method:
            //
            //    #    $driver->attach($this);  // <-- this line
            $this->linker->link($driver);
        } catch (ObserverCanNotBeOverwritten $_) {
            // ignore
        }

        $this->infoPrinter->print($driver);
    }

    public function update(ISubject $subject): void
    {
        $this->linker->update($subject);

        if ($subject instanceof IDriver) {
            $this->infoPrinter->print($subject);
        }
    }

    protected function memoryReportSetup(IDriver $driver): void
    {
        if ($this->loopProvider->hasLoop()) {
            $this->loopSetupFactory->create($driver)
                ->setup($this->loopProvider->getLoop())
            ;
        }
    }
}
