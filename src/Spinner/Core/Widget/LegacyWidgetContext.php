<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetContext;

final class LegacyWidgetContext implements ILegacyWidgetContext
{
    public function __construct(
        protected ILegacyWidgetComposite $widget,
    ) {
    }

    public function replaceWidget(ILegacyWidgetComposite $widget): void
    {
        $this->widget = $widget;
        $widget->setContext($this);
    }

    public function getWidget(): ILegacyWidgetComposite
    {
        return $this->widget;
    }
}
