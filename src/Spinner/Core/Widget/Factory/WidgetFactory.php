<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final class WidgetFactory implements IWidgetFactory
{
    private null|IWidgetSettings|IWidgetConfig $widgetSettings = null;

    public function __construct(
        private readonly IWidgetConfigFactory $widgetConfigFactory,
        private readonly IWidgetRevolverFactory $widgetRevolverFactory,
        private readonly IWidgetBuilder $widgetBuilder,
    ) {
    }

    public function create(): IWidget
    {
        $widgetConfig =
            $this->widgetConfigFactory->create($this->widgetSettings);

        $revolver =
            $this->widgetRevolverFactory->create(
                $widgetConfig->getWidgetRevolverConfig()
            );

        $this->widgetSettings = null;

        return $this->widgetBuilder
            ->withLeadingSpacer($widgetConfig->getLeadingSpacer())
            ->withTrailingSpacer($widgetConfig->getTrailingSpacer())
            ->withWidgetRevolver($revolver)
            ->build()
        ;
    }

    public function using(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetFactory
    {
        $this->widgetSettings = $widgetSettings;
        return $this;
    }
}
