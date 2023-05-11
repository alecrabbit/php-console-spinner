<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Core\Builder\Contract\ISignalHandlersSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\SignalHandlersSetup;
use AlecRabbit\Spinner\Exception\LogicException;

final class SignalHandlersSetupBuilder implements ISignalHandlersSetupBuilder
{
    private ?ILoop $loop = null;
    private ?ILoopSettings $settings = null;

    public function build(): ISignalHandlersSetup
    {
        $this->validate();

        return
            new SignalHandlersSetup(
                $this->loop,
                $this->settings,
            );
    }

    private function validate(): void
    {
        match (true) {
            null === $this->loop => throw new LogicException('Loop is not set.'),
            $this->settings === null => throw new LogicException('Loop settings are not set.'),
            default => null,
        };
    }

    public function withLoop(ILoop $loop): ISignalHandlersSetupBuilder
    {
        $clone = clone $this;
        $clone->loop = $loop;
        return $clone;
    }

    public function withSettings(ILoopSettings $settings): ISignalHandlersSetupBuilder
    {
        $clone = clone $this;
        $clone->settings = $settings;
        return $clone;
    }
}
