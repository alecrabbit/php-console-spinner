<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final class WidgetFactory implements IWidgetFactory
{
    public function __construct(
        protected IWidgetConfigFactory $widgetConfigFactory,
        protected IWidgetRevolverFactory $widgetRevolverFactory,
        protected IWidgetBuilder $widgetBuilder,
    ) {
    }

    public function legacyCreateWidget(ILegacyWidgetSettings $widgetSettings): IWidget
    {
        return
            $this->widgetBuilder
                ->withLeadingSpacer($widgetSettings->getLeadingSpacer())
                ->withTrailingSpacer($widgetSettings->getTrailingSpacer())
                ->withWidgetRevolver(
                    $this->widgetRevolverFactory
                        ->legacyCreateWidgetRevolver($widgetSettings)
                )
                ->build()
        ;
    }

    public function createWidget(?IWidgetSettings $widgetSettings = null): IWidget
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
