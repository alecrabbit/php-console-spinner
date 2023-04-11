<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Option\OptionAttacher;
use AlecRabbit\Spinner\Contract\Option\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILegacySpinnerSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILegacySpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;

final class LegacySpinnerSettingsBuilder implements ILegacySpinnerSettingsBuilder
{
    public function __construct(
        protected ?ILoopProbe $loopProbe = null,
    ) {
    }

    public function build(): ILegacySpinnerSettings
    {
        $probe = $this->loopProbe instanceof ILoopProbe;

        $attachOption =
            $probe
                ? OptionAttacher::ENABLED
                : OptionAttacher::DISABLED;

        return
            new LegacySpinnerSettings(
                initializationOption: OptionInitialization::ENABLED,
                attachOption: $attachOption,
            );
    }
}
