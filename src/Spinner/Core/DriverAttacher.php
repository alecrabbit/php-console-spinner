<?php

declare(strict_types=1);

// 10.04.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverAttacher;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;

final class DriverAttacher implements IDriverAttacher
{
    private mixed $timer = null;
    private ?IDriver $driver = null;

    public function __construct(
        protected ILoop $loop,
        protected OptionAttacher $optionAttacher,
    ) {
    }

    public function attach(IDriver $driver): void
    {
        if ($this->optionAttacher === OptionAttacher::ENABLED) {
            $this->attachTimer($driver);

            if (null === $this->driver) {
                dump(__METHOD__);
                $driver->attach($this);
                $this->driver = $driver;
            }
        }
    }

    protected function attachTimer(IDriver $driver): void
    {
        dump(__METHOD__);
        $this->detachTimer();

        $interval = $driver->getInterval()->toSeconds();

        dump($interval);

        $this->timer =
            $this->loop->repeat(
                $interval,
                static fn() => $driver->render()
            );
    }

    private function detachTimer(): void
    {
        if ($this->timer) {
            $this->loop->cancel($this->timer);
            $this->timer = null;
        }
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->driver) {
            $this->attachTimer($subject);
        }
    }
}
