<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Exception\LogicException;

final class DriverLinker implements IDriverLinker
{
    private mixed $timer = null;
    private ?IDriver $driver = null;

    public function __construct(
        private readonly ILoop $loop,
    ) {
    }

    public function link(IDriver $driver): void
    {
        $this->assertDriverCanBeLinked($driver);

        $this->linkTimer($driver);

        if ($this->driver === null) {
            $this->observeDriver($driver);
        }
    }

    private function assertDriverCanBeLinked(IDriver $driver): void
    {
        if ($this->driver === null || $this->driver === $driver) {
            return;
        }
        throw new LogicException(
            'Other instance of driver is already linked.'
        );
    }

    private function linkTimer(IDriver $driver): void
    {
        $this->unlinkTimer();

        $interval = $driver->getInterval()->toSeconds();

        $this->timer =
            $this->loop->repeat(
                $interval,
                static fn() => $driver->render()
            );
    }

    private function unlinkTimer(): void
    {
        if ($this->timer) {
            $this->loop->cancel($this->timer);
            $this->timer = null;
        }
    }

    private function observeDriver(IDriver $driver): void
    {
        $this->driver = $driver;
        $driver->attach($this);
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->driver) {
            $this->linkTimer($subject);
        }
    }
}
