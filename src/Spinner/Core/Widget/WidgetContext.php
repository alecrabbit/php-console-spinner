<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

final class WidgetContext extends ASubject implements IWidgetContext
{
    protected IWidget $widget;

    public function __construct(
        IWidget $widget,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->adoptWidget($widget);
    }

    public function adoptWidget(IWidget $widget): void
    {
        $this->widget = $widget;
        $widget->envelopWithContext($this);
    }

    public function getWidget(): IWidget
    {
        return $this->widget;
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->widget) {
            $this->notify();
        }
    }

    public function getInterval(): IInterval
    {
        return $this->widget->getInterval();
    }
}
