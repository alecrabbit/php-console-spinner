<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRuntimeWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final class WidgetFactory implements IWidgetFactory
{
    public function __construct(
        protected IRuntimeWidgetConfigFactory $widgetConfigFactory,
        protected IWidgetRevolverFactory $widgetRevolverFactory,
        protected IWidgetBuilder $widgetBuilder,
    ) {
    }

    public function create(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidget
    {
        $widgetConfig = $this->widgetConfigFactory->create($widgetSettings);

        $revolver = $this->widgetRevolverFactory->create($widgetConfig->getWidgetRevolverConfig());

        return
            $this->widgetBuilder
                ->withLeadingSpacer($widgetConfig->getLeadingSpacer())
                ->withTrailingSpacer($widgetConfig->getTrailingSpacer())
                ->withWidgetRevolver($revolver)
                ->build()
        ;
    }
}
