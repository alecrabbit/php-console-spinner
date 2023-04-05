<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\OptionAttach;
use AlecRabbit\Spinner\Contract\OptionInitialization;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;

final class SpinnerSettingsBuilder implements ISpinnerSettingsBuilder
{
    public function __construct(
        protected ?ILoopProbe $loopProbe = null,
    ) {
    }

    public function build(): ISpinnerSettings
    {
        $probe = $this->loopProbe instanceof ILoopProbe;

        $attachOption =
            $probe
                ? OptionAttach::ENABLED
                : OptionAttach::DISABLED;

        return
            new SpinnerSettings(
                initializationOption: OptionInitialization::ENABLED,
                attachOption: $attachOption,
            );
    }
}
