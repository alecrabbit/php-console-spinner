<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final readonly class WidgetCompositeFactory implements IWidgetCompositeFactory
{
    public function __construct(
        protected IWidgetConfigFactory $widgetConfigFactory,
        protected IWidgetCompositeBuilder $widgetBuilder,
        protected IWidgetRevolverFactory $widgetRevolverFactory,
    ) {
    }

    public function create(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetComposite
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
