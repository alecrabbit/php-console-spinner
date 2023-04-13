<?php

declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Defaults\Contract\IAuxSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsProviderBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\Contract\ILoopSettingsFactory;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\NoCharPattern;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\Snake;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\NoStylePattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\Rainbow;

final class DefaultsProviderBuilder implements IDefaultsProviderBuilder
{
    public function __construct(
        protected ILoopSettingsFactory $loopSettingsBuilder,
        protected IAuxSettingsBuilder $auxSettingsBuilder,
        protected IDriverSettingsBuilder $driverSettingsBuilder,
        protected IWidgetSettingsBuilder $widgetSettingsBuilder,
        protected IWidgetSettingsBuilder $rootWidgetSettingsBuilder,
    ) {
    }

    public function build(): IDefaultsProvider
    {
        $widgetSettings = $this->getWidgetSettings();
        return
            new DefaultsProvider(
                auxSettings: $this->auxSettingsBuilder->build(),
                loopSettings: $this->loopSettingsBuilder->createLoopSettings(),
                driverSettings: $this->driverSettingsBuilder->build(),
                widgetSettings: $widgetSettings,
                rootWidgetSettings: $this->getRootWidgetSettings($widgetSettings),
            );
    }

    private function getWidgetSettings(): IWidgetSettings
    {
        return
            $this->widgetSettingsBuilder
                ->withLeadingSpacer(Frame::createEmpty())
                ->withTrailingSpacer(Frame::createSpace())
                ->withStylePattern(new NoStylePattern())
                ->withCharPattern(new NoCharPattern())
                ->build()
        ;
    }

    private function getRootWidgetSettings(IWidgetSettings $widgetSettings): Contract\IWidgetSettings
    {
        return
            $this->widgetSettingsBuilder
                ->withLeadingSpacer($widgetSettings->getLeadingSpacer())
                ->withTrailingSpacer($widgetSettings->getTrailingSpacer())
                ->withStylePattern(new Rainbow())
                ->withCharPattern(new Snake())
                ->build()
        ;
    }
}
