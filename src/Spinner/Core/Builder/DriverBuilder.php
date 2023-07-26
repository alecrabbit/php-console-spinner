<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Exception\LogicException;

final class DriverBuilder implements Contract\IDriverBuilder
{
    private ?IDriverOutput $driverOutput = null;
    private ?ILegacyDriverSettings $driverSettings = null;
    private ?ITimer $timer = null;
    private ?IInterval $initialInterval = null;
    private ?IObserver $observer = null;

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

    public function withDriverSettings(ILegacyDriverSettings $driverSettings): IDriverBuilder
    {
        $clone = clone $this;
        $clone->driverSettings = $driverSettings;
        return $clone;
    }

    public function withTimer(ITimer $timer): IDriverBuilder
    {
        $clone = clone $this;
        $clone->timer = $timer;
        return $clone;
    }

    public function withInitialInterval(IInterval $interval): IDriverBuilder
    {
        $clone = clone $this;
        $clone->initialInterval = $interval;
        return $clone;
    }

    public function build(): IDriver
    {
        $this->validate();

        return
            new Driver(
                output: $this->driverOutput,
                timer: $this->timer,
                initialInterval: $this->initialInterval ?? $this->createInitialInterval(),
                driverSettings: $this->driverSettings,
                observer: $this->observer,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->driverOutput === null => throw new LogicException('DriverOutput is not set.'),
            $this->driverSettings === null => throw new LogicException('DriverSettings are not set.'),
            $this->timer === null => throw new LogicException('Timer is not set.'),
            default => null,
        };
    }

    private function createInitialInterval(): IInterval
    {
        return $this->intervalFactory->createStill();
    }

    public function withObserver(IObserver $observer): IDriverBuilder
    {
        $clone = clone $this;
        $clone->observer = $observer;
        return $clone;
    }
}
