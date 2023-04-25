<?php
declare(strict_types=1);
// 25.04.23
namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

final class WidgetContext implements IWidgetContext
{
    public function __construct(
        protected IWidget $widget,
    ) {
    }

    public function replaceWidget(IWidget $widget): void
    {
        $this->widget = $widget;
        $widget->replaceContext($this);
    }

    public function getWidget(): IWidget
    {
        return $this->widget;
    }
}
