<?php

declare(strict_types=1);
// 20.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\ILegacyPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidgetSettingsFactory;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Pattern\CharPattern\NoCharPattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\NoStylePattern;

final class WidgetSettingsFactory implements IWidgetSettingsFactory
{
    public function __construct(
        protected IWidgetSettingsBuilder $widgetSettingsBuilder,
    ) {
    }

    public function createFromConfig(IWidgetConfig $config): IWidgetSettings
    {
        return
            $this->widgetSettingsBuilder
                ->withLeadingSpacer($config->getLeadingSpacer() ?? $this->defaultLeadingSpacer())
                ->withTrailingSpacer($config->getTrailingSpacer() ?? $this->defaultTrailingSpacer())
                ->withStylePattern($config->getStylePattern() ?? $this->defaultStylePattern())
                ->withCharPattern($config->getCharPattern() ?? $this->defaultCharPattern())
                ->build()
        ;
    }

    private function defaultLeadingSpacer(): IFrame
    {
        return Frame::createEmpty();
    }

    private function defaultTrailingSpacer(): IFrame
    {
        return Frame::createSpace();
    }

    private function defaultStylePattern(): ILegacyPattern
    {
        return new NoStylePattern();
    }

    private function defaultCharPattern(): ILegacyPattern
    {
        return new NoCharPattern();
    }
}
