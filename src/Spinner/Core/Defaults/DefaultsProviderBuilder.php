<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettingsBuilder;

final class DefaultsProviderBuilder implements IDefaultsProviderBuilder
{
    public function __construct(
        protected ILoopSettingsBuilder $loopSettingsBuilder,
        protected ISpinnerSettingsBuilder $spinnerSettingsBuilder,
        protected IAuxSettingsBuilder $auxSettingsBuilder,
        protected IDriverSettingsBuilder $driverSettingsBuilder,
    ) {
    }

    public function build(): IDefaultsProvider
    {
        return
            new DefaultsProvider(
                auxSettings: $this->auxSettingsBuilder->build(),
                loopSettings: $this->loopSettingsBuilder->build(),
                spinnerSettings: $this->spinnerSettingsBuilder->build(),
                driverSettings: $this->driverSettingsBuilder->build(),
            );
    }
}
