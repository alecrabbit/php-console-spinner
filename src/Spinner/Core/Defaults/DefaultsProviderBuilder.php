<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILegacySpinnerSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\Snake;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\Rainbow;

final class DefaultsProviderBuilder implements IDefaultsProviderBuilder
{
    protected IPattern $stylePattern;
    protected IPattern $charPattern;

    public function __construct(
        protected ILoopSettingsBuilder $loopSettingsBuilder,
        protected ILegacySpinnerSettingsBuilder $spinnerSettingsBuilder,
        protected IAuxSettingsBuilder $auxSettingsBuilder,
        protected IDriverSettingsBuilder $driverSettingsBuilder,
        protected IWidgetSettingsBuilder $widgetSettingsBuilder,
        protected IWidgetSettingsBuilder $rootWidgetSettingsBuilder,
    ) {
        $this->stylePattern = new Rainbow();
        $this->charPattern = new Snake();
    }

    public function build(): IDefaultsProvider
    {
        $widgetSettings = $this->widgetSettingsBuilder->build();
        return
            new DefaultsProvider(
                auxSettings: $this->auxSettingsBuilder->build(),
                loopSettings: $this->loopSettingsBuilder->build(),
                spinnerSettings: $this->spinnerSettingsBuilder->build(),
                driverSettings: $this->driverSettingsBuilder->build(),
                widgetSettings: $widgetSettings,
                rootWidgetSettings: $this->getRootWidgetSettings($widgetSettings),
            );
    }

    private function getRootWidgetSettings(IWidgetSettings $widgetSettings): Contract\IWidgetSettings
    {
        return new WidgetSettings(
            $widgetSettings->getLeadingSpacer(),
            $widgetSettings->getTrailingSpacer(),
            stylePattern: $this->stylePattern,
            charPattern: $this->charPattern,
        );
    }
}
