<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Core\Builder\Contract\ILegacyLoopAutoStarterBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacyLoopAutoStarter;
use AlecRabbit\Spinner\Core\LegacyLoopAutoStarter;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @deprecated
 */
final class LegacyLoopAutoStarterBuilder implements ILegacyLoopAutoStarterBuilder
{
    private ?ILegacyLoopSettings $settings = null;

    public function build(): ILegacyLoopAutoStarter
    {
        $this->validate();

        return
            new LegacyLoopAutoStarter(
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

    public function withSettings(ILegacyLoopSettings $settings): ILegacyLoopAutoStarterBuilder
    {
        $clone = clone $this;
        $clone->settings = $settings;
        return $clone;
    }
}
