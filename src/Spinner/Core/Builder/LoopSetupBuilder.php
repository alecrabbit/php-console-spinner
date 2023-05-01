<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettings;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Spinner\Exception\LogicException;

final class LoopSetupBuilder implements ILoopSetupBuilder
{
    private ?ILoop $loop = null;
    private ?ILoopSettings $settings = null;

    public function build(): ILoopSetup
    {
        $this->validate();

        return new LoopSetup(
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
}
