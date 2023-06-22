<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\LogicException;

final class WidgetContext extends ASubject implements IWidgetContext
{
    public function __construct(
        protected ?IWidget $widget = null,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
    }

    public function adoptWidget(IWidget $widget): void
    {
        $this->widget?->detach($this);
        $this->widget = $widget;
        $this->widget->attach($this);
    }

    public function getWidget(): ?IWidget
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
