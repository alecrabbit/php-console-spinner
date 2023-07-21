<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Core\Builder\Contract\ILoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopAutoStarter;
use AlecRabbit\Spinner\Core\LoopAutoStarter;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Spinner\Exception\LogicException;

final class LoopAutoStarterBuilder implements ILoopAutoStarterBuilder
{
    private ?ILegacyLoopSettings $settings = null;

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

    public function withSettings(ILegacyLoopSettings $settings): ILoopAutoStarterBuilder
    {
        $clone = clone $this;
        $clone->settings = $settings;
        return $clone;
    }
}
