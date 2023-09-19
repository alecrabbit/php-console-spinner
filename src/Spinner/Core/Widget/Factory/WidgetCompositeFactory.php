<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final class WidgetCompositeFactory implements IWidgetCompositeFactory
{
    public function __construct(
        protected IWidgetConfigFactory $widgetConfigFactory,
        protected IWidgetCompositeBuilder $widgetBuilder,
        protected IWidgetRevolverFactory $widgetRevolverFactory,
    ) {
    }

    public function legacyCreateWidget(ILegacyWidgetSettings $widgetSettings): IWidgetComposite
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

    public function createWidget(?IWidgetSettings $widgetSettings = null): IWidgetComposite
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
