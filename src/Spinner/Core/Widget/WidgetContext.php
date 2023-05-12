<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

final class WidgetContext implements IWidgetContext
{
    public function __construct(
        protected IWidgetComposite $widget,
    ) {
    }

    public function replaceWidget(IWidgetComposite $widget): void
    {
        $this->widget = $widget;
        $widget->replaceContext($this);
    }

    public function getWidget(): IWidgetComposite
    {
        return $this->widget;
    }
}
