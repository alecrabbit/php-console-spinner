<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;

final readonly class DriverLinkerWithOutput implements IDriverLinker
{
    public function __construct(
        private IDriverLinker $linker,
        private IOutput $output,
    ) {
    }

    public function link(IDriver $driver): void
    {
        // this depends on the implementation of the DriverLinker::link() method
        //
        // Observer can not be overwritten so `attach()` will throw and should be the last line in the method
        //    #    $driver->attach($this);  // <-- this line

        $driver->attach($this);

        try {
            $this->linker->link($driver);
        } catch (ObserverCanNotBeOverwritten $_) {
            // ignore
        }

        $this->writeInterval($driver);
    }

    private function writeInterval(IDriver $driver): void
    {
        $this->output->write($this->format($driver->getInterval()));
    }

    private function format(IInterval $getInterval): string
    {
        return sprintf(
            '[Driver] Render interval: %sms' . PHP_EOL,
            $getInterval->toMilliseconds()
        );
    }

    public function update(ISubject $subject): void
    {
        $this->linker->update($subject);
        if ($subject instanceof IDriver) {
            $this->writeInterval($subject);
        }
    }
}
