<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;

final readonly class DriverLinkerWithOutput implements IDriverLinker
{
    public function __construct(
        private IDriverLinker $linker,
        private IOutput $output,
    ) {
    }

    public function link(IDriver $driver): void
    {
        $this->linker->link($driver);
        $this->output->write($this->format($driver->getInterval()));
    }

    private function format(IInterval $getInterval): string
    {
        return sprintf(
            'Render interval: %sms',
            $getInterval->toMilliseconds()
        );
    }

    public function update(ISubject $subject): void
    {
        $this->linker->update($subject);
    }
}
