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

final readonly class WidgetFactory implements IWidgetFactory
{
    public function __construct(
        private IWidgetConfigFactory $widgetConfigFactory,
        private IWidgetRevolverFactory $widgetRevolverFactory,
        private IWidgetBuilder $widgetBuilder,
        private null|IWidgetSettings|IWidgetConfig $widgetSettings = null,
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

        return $this->widgetBuilder
            ->withLeadingSpacer($widgetConfig->getLeadingSpacer())
            ->withTrailingSpacer($widgetConfig->getTrailingSpacer())
            ->withWidgetRevolver($revolver)
            ->build()
        ;
    }

    public function using(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetFactory
    {
        return new self(
            widgetConfigFactory: $this->widgetConfigFactory,
            widgetRevolverFactory: $this->widgetRevolverFactory,
            widgetBuilder: $this->widgetBuilder,
            widgetSettings: $widgetSettings,
        );
    }
}
