<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core;

use AlecRabbit\Lib\Spinner\Core\Contract\IIntervalFormatter;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;

final readonly class DriverLinkerWithOutput implements IDriverLinker
{
    public function __construct(
        private IDriverLinker $linker,
        private IOutput $output,
        private IIntervalFormatter $formatter = new IntervalFormatter(),
    ) {
    }

    public function link(IDriver $driver): void
    {
        // this depends on the implementation of the DriverLinker::link() method

        $driver->attach($this); // setting $this as an observer

        try {
            // Observer can not be overwritten so `attach()` will throw and should
            // be the last line in the method:
            //
            //    #    $driver->attach($this);  // <-- this line
            $this->linker->link($driver);
        } catch (ObserverCanNotBeOverwritten $_) {
            // ignore
        }

        $this->write($driver);
    }

    private function write(IDriver $driver): void
    {
        $this->output->write(
            $this->formatter->format($driver)
        );
    }

    public function update(ISubject $subject): void
    {
        $this->linker->update($subject);
        
        if ($subject instanceof IDriver) {
            $this->write($subject);
        }
    }
}
