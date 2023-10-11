<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacySpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Legacy\ILegacyWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IRootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected IWidgetFactory $widgetFactory,
        protected ISettingsProvider $settingsProvider,
    ) {
    }

    public function create(?ISpinnerSettings $spinnerSettings = null): ISpinner
    {
        $widgetSettings =
            $spinnerSettings?->getWidgetSettings() ?? $this->getRootWidgetSettings();

        $widget = $this->widgetFactory->create($widgetSettings);

        return
            new Spinner($widget);
    }

    protected function getRootWidgetSettings(): ?IRootWidgetSettings
    {
        return
            $this->settingsProvider->getUserSettings()->get(IRootWidgetSettings::class);
    }
}
