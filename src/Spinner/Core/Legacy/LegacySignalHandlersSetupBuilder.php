<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Legacy;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalHandlersSetup;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyLoopSettings;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @deprecated Will be removed
 */
final class LegacySignalHandlersSetupBuilder implements ILegacySignalHandlersSetupBuilder
{
    private ?ILoop $loop = null;
    private ?ILegacyLoopSettings $loopSettings = null;
    private ?ILegacyDriverSettings $driverSettings = null;

    public function build(): ILegacySignalHandlersSetup
    {
        $this->validate();

        return
            new LegacySignalHandlersSetup(
                $this->loop,
                $this->loopSettings,
                $this->driverSettings,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->loop === null => throw new LogicException('Loop is not set.'),
            $this->loopSettings === null => throw new LogicException('Loop settings are not set.'),
            $this->driverSettings === null => throw new LogicException('Driver settings are not set.'),
            default => null,
        };
    }

    public function withLoop(ILoop $loop): ILegacySignalHandlersSetupBuilder
    {
        $clone = clone $this;
        $clone->loop = $loop;
        return $clone;
    }

    public function withLoopSettings(ILegacyLoopSettings $settings): ILegacySignalHandlersSetupBuilder
    {
        $clone = clone $this;
        $clone->loopSettings = $settings;
        return $clone;
    }

    public function withDriverSettings(ILegacyDriverSettings $settings): ILegacySignalHandlersSetupBuilder
    {
        $clone = clone $this;
        $clone->driverSettings = $settings;
        return $clone;
    }
}
