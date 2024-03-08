<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Driver;

use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Exception\DriverCanNotBeReplaced;
use AlecRabbit\Spinner\Exception\LogicException;

final class DriverLinker implements IDriverLinker
{
    private mixed $renderTimer = null;
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
            $this->driver = $driver;
            $driver->attach($this); // [f61da847-b343-42d1-9cf0-9a7ecbba737d]
        }
    }

    /**
     * @throws LogicException
     */
    private function assertDriverCanBeLinked(IDriver $driver): void
    {
        if ($this->driver === null || $this->driver === $driver) {
            return;
        }
        throw new DriverCanNotBeReplaced(
            'Other instance of driver is already linked.'
        );
    }

    private function linkTimer(IDriver $driver): void
    {
        if ($this->renderTimer) {
            $this->loop->cancel($this->renderTimer);
        }

        $this->renderTimer =
            $this->loop->repeat(
                $driver->getInterval()->toSeconds(),
                static fn() => $driver->render(),
            );
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->driver) {
            $this->linkTimer($subject);
        }
    }
}
