<?php

declare(strict_types=1);
// 06.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Exception\LogicException;

final class LoopSetupBuilder implements ILoopSetupBuilder
{
    protected ?ILoop $loop = null;
    protected ?ILoopSettings $settings = null;
    protected ?IDriver $driver = null;

    public function build(): ILoopSetup
    {
        $this->validate();

        return
            new LoopSetup(
                $this->loop,
                $this->settings,
                $this->driver,
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->loop => throw new LogicException('Loop is not set.'),
            null === $this->settings => throw new LogicException('Loop settings are not set.'),
            null === $this->driver => throw new LogicException('Driver is not set.'),
            default => null,
        };
    }

    public function withLoop(ILoop $loop): ILoopSetupBuilder
    {
        $clone = clone $this;
        $clone->loop = $loop;
        return $clone;
    }

    public function withSettings(ILoopSettings $settings): ILoopSetupBuilder
    {
        $clone = clone $this;
        $clone->settings = $settings;
        return $clone;
    }

    public function withDriver(IDriver $driver): ILoopSetupBuilder
    {
        $clone = clone $this;
        $clone->driver = $driver;
        return $clone;
    }
}
