<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Core\Builder\Contract\ILoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopAutoStarter;
use AlecRabbit\Spinner\Core\LoopAutoStarter;
use AlecRabbit\Spinner\Core\Settings\Contract\ILoopSettings;
use AlecRabbit\Spinner\Exception\LogicException;

final class LoopAutoStarterBuilder implements ILoopAutoStarterBuilder
{
    private ?ILoopSettings $settings = null;

    public function build(): ILoopAutoStarter
    {
        $this->validate();

        return
            new LoopAutoStarter(
                $this->settings,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->settings === null => throw new LogicException('Loop settings are not set.'),
            default => null,
        };
    }

    public function withSettings(ILoopSettings $settings): ILoopAutoStarterBuilder
    {
        $clone = clone $this;
        $clone->settings = $settings;
        return $clone;
    }
}
