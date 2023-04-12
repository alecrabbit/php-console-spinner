<?php
declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

final class WidgetFactory implements IWidgetFactory
{
    public function __construct(
        protected IWidgetBuilder $widgetBuilder,
        protected IWidgetRevolverBuilder $widgetRevolverBuilder,
    ) {
    }
    public function createWidget(IWidgetSettings $widgetSettings): IWidgetComposite
    {
        return $this->widgetBuilder->build();
    }
}
