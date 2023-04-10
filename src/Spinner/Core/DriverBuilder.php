<?php

declare(strict_types=1);
// 10.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Exception\LogicException;
use Closure;

final class DriverBuilder implements Contract\IDriverBuilder
{
    protected ?IDriverOutput $driverOutput = null;
    protected ?ITimer $timer = null;
    protected ?Closure $intervalCb = null;

    public function __construct(
        protected IIntervalFactory $intervalFactory,
    ) {
    }

    public function withDriverOutput(IDriverOutput $driverOutput): IDriverBuilder
    {
        $clone = clone $this;
        $clone->driverOutput = $driverOutput;
        return $clone;
    }

    public function withTimer(ITimer $timer): IDriverBuilder
    {
        $clone = clone $this;
        $clone->timer = $timer;
        return $clone;
    }

    public function withIntervalCallback(Closure $intervalCb): IDriverBuilder
    {
        $clone = clone $this;
        $clone->intervalCb = $intervalCb;
        return $clone;
    }

    public function build(): IDriver
    {
        $this->validate();

        return
            new Driver(
                driverOutput: $this->driverOutput,
                timer: $this->timer,
                intervalCb: $this->intervalCb ?? $this->getIntervalCb(),
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->driverOutput => throw new LogicException('DriverOutput is not set.'),
            null === $this->timer => throw new LogicException('Timer is not set.'),
            default => null,
        };
    }

    protected function getIntervalCb(): Closure
    {
        return
            fn() => $this->intervalFactory->createStill();
    }
}
