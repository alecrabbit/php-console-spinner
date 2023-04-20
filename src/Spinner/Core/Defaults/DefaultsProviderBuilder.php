<?php

declare(strict_types=1);

// 05.04.23

namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\WidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\NoCharPattern;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\Snake;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\NoStylePattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\Rainbow;

final class DefaultsProviderBuilder implements IDefaultsProviderBuilder
{
    public function __construct(
        protected ILoopSettingsFactory $loopSettingsFactory,
        protected ITerminalSettingsFactory $terminalSettingsFactory,
        protected IAuxSettingsBuilder $auxSettingsBuilder,
        protected IDriverSettingsBuilder $driverSettingsBuilder,
    ) {
    }

    public function build(): IDefaultsProvider
    {
        return new DefaultsProvider(
            auxSettings: $this->auxSettingsBuilder->build(),
            terminalSettings: $this->terminalSettingsFactory->createTerminalSettings(),
            loopSettings: $this->loopSettingsFactory->createLoopSettings(),
            driverSettings: $this->driverSettingsBuilder->build(),
            widgetConfig: $this->getWidgetConfig(),
            rootWidgetConfig: $this->getRootWidgetConfig(),
        );
    }

    protected function getRootWidgetConfig(): IWidgetConfig
    {
        return
            new WidgetConfig(
                stylePattern: new Rainbow(),
                charPattern: new Snake(),
            );
    }

    protected function getWidgetConfig(): IWidgetConfig
    {
        return new WidgetConfig(
            leadingSpacer: Frame::createEmpty(),
            trailingSpacer: Frame::createSpace(),
            stylePattern: new NoStylePattern(),
            charPattern: new NoCharPattern(),
        );
    }
}
