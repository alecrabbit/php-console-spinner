<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Settings;

use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Contract\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Config\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Config\LegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\Snake;
use AlecRabbit\Spinner\Core\Pattern\NoCharPattern;
use AlecRabbit\Spinner\Core\Pattern\NoStylePattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\Rainbow;
use AlecRabbit\Spinner\Core\Settings\LegacySettingsProvider;

final class SettingsProviderBuilder implements ISettingsProviderBuilder
{
    public function __construct(
        protected ILoopSettingsFactory $loopSettingsFactory,
        protected ITerminalSettingsFactory $terminalSettingsFactory,
        protected IAuxSettingsBuilder $auxSettingsBuilder,
        protected IDriverSettingsBuilder $driverSettingsBuilder,
    ) {
    }

    public function build(): ILegacySettingsProvider
    {
        return new LegacySettingsProvider(
            auxSettings: $this->auxSettingsBuilder->build(),
            terminalSettings: $this->terminalSettingsFactory->createTerminalSettings(),
            loopSettings: $this->loopSettingsFactory->createLoopSettings(),
            driverSettings: $this->driverSettingsBuilder->build(),
            widgetConfig: $this->getWidgetConfig(),
            rootWidgetConfig: $this->getRootWidgetConfig(),
        );
    }

    protected function getWidgetConfig(): ILegacyWidgetConfig
    {
        return
            new LegacyWidgetConfig(
                leadingSpacer: CharFrame::createEmpty(),
                trailingSpacer: CharFrame::createSpace(),
                stylePattern: new NoStylePattern(),
                charPattern: new NoCharPattern(),
            );
    }

    protected function getRootWidgetConfig(): ILegacyWidgetConfig
    {
        return
            new LegacyWidgetConfig(
                stylePattern: new Rainbow(),
                charPattern: new Snake(),
            );
    }
}
