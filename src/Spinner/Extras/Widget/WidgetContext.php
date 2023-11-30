<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

final class WidgetContext extends ASubject implements IWidgetContext
{
    public function __construct(
        protected ?IWidget $widget = null,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);

        if ($this->widget instanceof IWidget) {
            $this->update($this->widget);
        }
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->widget) {
            $this->notify();
        }
    }

    public function setWidget(?IWidget $widget): void
    {
        $this->widget?->detach($this);
        $this->widget = $widget;

        if ($this->widget === null) {
            $this->notify();
            return;
        }

        $this->widget->attach($this);
        $this->update($this->widget);
    }

    public function getWidget(): ?IWidget
    {
        return $this->widget;
    }

    public function getInterval(): ?IInterval
    {
        return $this->widget?->getInterval();
    }
}
