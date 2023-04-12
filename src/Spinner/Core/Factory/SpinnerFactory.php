<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Defaults\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected IDefaultsProvider $defaultsProvider,
        protected IWidgetFactory $widgetFactory,
    ) {
    }

    public function createSpinner(?ISpinnerSettings $settings = null): ISpinner
    {
        return
            new Spinner(
                $this->createWidget($settings),
            );
    }

    protected function createWidget(?ISpinnerSettings $settings): IWidgetComposite
    {
        $widgetSettings =
            $settings?->getWidgetSettings() ?? $this->defaultsProvider->getRootWidgetSettings();

        return
            $this->widgetFactory->createWidget($widgetSettings);
    }
}
