<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

abstract class AWidgetContext implements IWidgetContext
{
    public function __construct(
        protected IWidgetComposite $widget,
    ) {
    }

    public function replaceWidget(IWidgetComposite $widget): void
    {
        $this->widget = $widget;
        $widget->setContext($this);
    }

    public function getWidget(): IWidgetComposite
    {
        return $this->widget;
    }
}
