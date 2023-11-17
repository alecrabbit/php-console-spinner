<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class DriverBuilder implements IDriverBuilder
{
    private ?ISequenceStateWriter $sequenceStateWriter = null;
    private ?IDeltaTimer $deltaTimer = null;
    private ?IInterval $initialInterval = null;
    private ?IObserver $observer = null;
    private ?IDriverConfig $driverConfig = null;
    private ?ISequenceStateBuilder $sequenceStateBuilder = null;

    public function withSequenceStateWriter(ISequenceStateWriter $sequenceStateWriter): IDriverBuilder
    {
        $clone = clone $this;
        $clone->sequenceStateWriter = $sequenceStateWriter;
        return $clone;
    }

    public function withDeltaTimer(IDeltaTimer $timer): IDriverBuilder
    {
        $clone = clone $this;
        $clone->deltaTimer = $timer;
        return $clone;
    }

    public function withInitialInterval(IInterval $interval): IDriverBuilder
    {
        $clone = clone $this;
        $clone->initialInterval = $interval;
        return $clone;
    }

    public function withObserver(IObserver $observer): IDriverBuilder
    {
        $clone = clone $this;
        $clone->observer = $observer;
        return $clone;
    }

    public function build(): IDriver
    {
        $this->validate();

        return new Driver(
            stateWriter: $this->sequenceStateWriter,
            stateBuilder: $this->sequenceStateBuilder,
            deltaTimer: $this->deltaTimer,
            initialInterval: $this->initialInterval,
            driverConfig: $this->driverConfig,
            observer: $this->observer,
        );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->sequenceStateWriter === null => throw new LogicException('SequenceStateWriter is not set.'),
            $this->sequenceStateBuilder === null => throw new LogicException('SequenceStateBuilder is not set.'),
            $this->deltaTimer === null => throw new LogicException('Timer is not set.'),
            $this->initialInterval === null => throw new LogicException('InitialInterval is not set.'),
            $this->driverConfig === null => throw new LogicException('DriverConfig is not set.'),
            default => null,
        };
    }

    public function withDriverConfig(IDriverConfig $driverConfig): IDriverBuilder
    {
        $clone = clone $this;
        $clone->driverConfig = $driverConfig;
        return $clone;
    }

    public function withSequenceStateBuilder(ISequenceStateBuilder $sequenceStateBuilder): IDriverBuilder
    {
        $clone = clone $this;
        $clone->sequenceStateBuilder = $sequenceStateBuilder;
        return $clone;
    }
}
