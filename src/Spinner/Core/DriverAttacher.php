<?php

declare(strict_types=1);
// 10.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverAttacher;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

final class DriverAttacher implements IDriverAttacher
{
    protected mixed $timer = null;

    public function __construct(
        protected ILoop $loop,
        protected OptionAttacher $optionAttacher,
    ) {
    }

    public function attach(IDriver $driver): void
    {
        dump(__METHOD__);
        $this->detach();
        $this->timer =
            $this->loop->repeat(
                $driver->getInterval()->toSeconds(),
                static fn() => $driver->render()
            );
        dump($this);
    }

    protected function detach(): void
    {
        if ($this->timer) {
            $this->loop->cancel($this->timer);
            $this->timer = null;
        }
    }
}
