<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsProviderBuilder;

final class DefaultsProviderBuilder implements IDefaultsProviderBuilder
{
    public function __construct(
        protected ILoopSettingsBuilder $loopSettingsBuilder,
        protected ISpinnerSettingsBuilder $spinnerSettingsBuilder,
    ) {
    }

    public function build(): IDefaultsProvider
    {
        return
            new DefaultsProvider(
                spinnerSettings: $this->spinnerSettingsBuilder->build(),
                loopSettings: $this->loopSettingsBuilder->build(),
            );
    }
}
