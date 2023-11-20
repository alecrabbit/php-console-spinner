<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Tests\Helper\PickLock;

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

        $this->hackDriver($driver);

        $this->writeInterval($driver);
    }

    private function hackDriver(IDriver $driver): void
    {
        if ($driver instanceof ADriver) {
            // DON'T DO THIS AT HOME 🙂 (or at work, especially in production)
            PickLock::setValue($driver, 'observer', null);
            $driver->attach($this);
        }
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
