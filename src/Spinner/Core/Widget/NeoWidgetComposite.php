<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\IPlaceholder;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Placeholder;
use AlecRabbit\Spinner\Core\Widget\Contract\INeoWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use WeakMap;

final class NeoWidgetComposite extends ASubject implements INeoWidgetComposite

{
    private int $count;
    private IInterval $interval;
    private ISequenceFrame $emptyFrame;

    public function __construct(
        private readonly WeakMap $widgets,
        private readonly IIntervalComparator $intervalComparator,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);

        $this->count = $this->countWidgets();
        $this->interval = $this->createInterval();
        $this->emptyFrame = $this->createFrame();
    }

    private function countWidgets(): int
    {
        return $this->widgets->count();
    }

    private function createInterval(): Interval
    {
        return new Interval();
    }

    private function createFrame(): ISequenceFrame
    {
        return new CharSequenceFrame('', 0);
    }

    public function getFrame(?float $dt = null): ISequenceFrame
    {
        if ($this->count === 0) {
            return $this->emptyFrame;
        }
    }

    public function add(IWidget $widget, ?IPlaceholder $placeholder = null): IPlaceholder
    {
        if ($placeholder === null) {
            $placeholder = new Placeholder();
        }

        $this->widgets->offsetSet($placeholder, $widget);

        $this->internalUpdate();

        return $placeholder;
    }

    private function internalUpdate(): void
    {
        $this->count = $this->countWidgets();
        $this->smallestInterval();
        $this->notify();
    }

    private function smallestInterval(): void
    {
        $this->interval = $this->getWidgetsInterval();
    }

    private function getWidgetsInterval(): IInterval
    {
        $interval = $this->createInterval();
        foreach ($this->widgets as $widget) {
            $interval = $this->intervalComparator->smallest(
                $interval,
                $widget->getInterval()
            );
        }
        return $interval;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function remove(IPlaceholder|IWidget $item): void
    {
        if ($item instanceof IPlaceholder) {
            $this->widgets->offsetUnset($item);
        }

        foreach ($this->widgets as $placeholder => $widget) {
            if ($widget === $item) {
                $this->widgets->offsetUnset($placeholder);
            }
        }

        $this->internalUpdate();
    }

    public function update(ISubject $subject): void
    {
        if ($subject instanceof IWidget && $this->has($subject)) {
            $this->internalUpdate();
        }
    }

    private function has(IWidget $widget): bool
    {
        foreach ($this->widgets as $w) {
            if ($w === $widget) {
                return true;
            }
        }
        return false;
    }
}
