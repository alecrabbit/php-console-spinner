<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core;

use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportSetupFactory;
use AlecRabbit\Lib\Spinner\Contract\IDriverInfoPrinter;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;

/**
 * This class is a decorator for the DriverLinker class.
 * !!!ATTENTION!!! Use it for demonstration purposes only.
 *
 * Sets up a memory report if the loop is available.
 * Writes the current driver interval to the output on 'link' and 'update' method calls.
 */
final readonly class DecoratedDriverLinker implements IDriverLinker
{
    public function __construct(
        private IDriverLinker $linker,
        private IDriverInfoPrinter $infoPrinter,
        private ILoopProvider $loopProvider,
        private IMemoryReportSetupFactory $reportSetupFactory,
    ) {
    }

    public function link(IDriver $driver): void
    {
        $this->doLink($driver);

        $this->setupMemoryReport($driver);
    }

    private function doLink(IDriver $driver): void
    {
        // this method depends on the implementation of the DriverLinker::link() method

        $driver->attach($this); // setting $this as an observer

        try {
            // Observer can not be overwritten calling `attach()` will throw
            // so it should be the last line in the method:
            //
            //    #    $driver->attach($this);  // <-- this line [f61da847-b343-42d1-9cf0-9a7ecbba737d]
            $this->linker->link($driver);       // <-- in this method
        } catch (ObserverCanNotBeOverwritten $_) {
            // ignore
        }

        $this->infoPrinter->print($driver);
    }

    private function setupMemoryReport(IDriver $driver): void
    {
        $reportSetup = $this->reportSetupFactory->create($driver);

        if ($this->loopProvider->hasLoop()) {
            $reportSetup->setup($this->loopProvider->getLoop());
        }
    }

    public function update(ISubject $subject): void
    {
        $this->linker->update($subject);

        if ($subject instanceof IDriver) {
            $this->infoPrinter->print($subject);
        }
    }
}
