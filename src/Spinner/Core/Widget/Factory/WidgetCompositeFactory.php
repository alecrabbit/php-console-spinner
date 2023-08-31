<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetCompositeFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use RuntimeException;

final class WidgetCompositeFactory implements IWidgetCompositeFactory
{
    public function __construct(
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
                        ->createWidgetRevolver($widgetSettings)
                )
                ->build()
        ;
    }

    public function createWidget(?IWidgetSettings $widgetSettings = null): IWidgetComposite
    {
        // TODO: Implement createWidget() method.
        throw new RuntimeException('Not implemented.');
    }
}
