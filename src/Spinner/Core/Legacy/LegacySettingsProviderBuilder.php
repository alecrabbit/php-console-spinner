<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Settings\Legacy;

use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacySettingsProviderBuilder;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Config\Legacy\Contract\ILegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Legacy\LegacyWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Legacy\ILegacyTerminalSettingsFactory;
use AlecRabbit\Spinner\Core\Legacy\ILegacyLoopSettingsFactory;
use AlecRabbit\Spinner\Core\Pattern\Legacy\CharPattern\Snake;
use AlecRabbit\Spinner\Core\Pattern\Legacy\NoCharPattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\NoStylePattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\StylePattern\Rainbow;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacySettingsProvider;

/**
 * @deprecated Will be removed
 */
final class LegacySettingsProviderBuilder implements ILegacySettingsProviderBuilder
{
    public function __construct(
        protected ILegacyLoopSettingsFactory $loopSettingsFactory,
        protected ILegacyTerminalSettingsFactory $terminalSettingsFactory,
        protected ILegacyAuxSettingsBuilder $auxSettingsBuilder,
        protected ILegacyDriverSettingsBuilder $driverSettingsBuilder,
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
