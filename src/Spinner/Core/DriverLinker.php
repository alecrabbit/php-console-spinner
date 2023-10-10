<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Exception\LogicException;

final class DriverLinker implements IDriverLinker
{
    private mixed $timer = null;
    private ?IDriver $driver = null;

    public function __construct(
        private readonly ILoop $loop,
        private readonly LinkerMode $linkerMode,
    ) {
    }

    public function link(IDriver $driver): void
    {
        $this->assertDriver($driver);

        if ($this->isLinkingEnabled()) {
            $this->doLink($driver);
        }
    }

    private function assertDriver(IDriver $driver): void
    {
        if ($this->driver === null || $this->driver === $driver) {
            return;
        }
        throw new LogicException(
            'Other instance of driver is already linked.'
        );
    }

    protected function isLinkingEnabled(): bool
    {
        return $this->linkerMode === LinkerMode::ENABLED;
    }

    protected function doLink(IDriver $driver): void
    {
        $this->linkTimer($driver);

        if ($this->driver === null) {
            $this->observe($driver);
        }
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

    private function observe(IDriver $driver): void
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
