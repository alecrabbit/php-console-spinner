<?php

declare(strict_types=1);

// 12.04.23
namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final class WidgetFactory implements IWidgetFactory
{
    public function __construct(
        protected IWidgetBuilder $widgetBuilder,
        protected IWidgetRevolverFactory $widgetRevolverBuilder,
    ) {
    }

    public function createWidget(IWidgetSettings $widgetSettings): IWidgetComposite
    {
        return
            $this->widgetBuilder
                ->withLeadingSpacer($widgetSettings->getLeadingSpacer())
                ->withTrailingSpacer($widgetSettings->getTrailingSpacer())
                ->withWidgetRevolver($this->widgetRevolverBuilder->createWidgetRevolver($widgetSettings))
                ->build()
        ;
    }
}
