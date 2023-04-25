<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetContext;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use SplObserver;
use SplSubject;
use WeakMap;

final class Widget implements IWidget
{
    /** @var WeakMap<IObserver, IObserver> */
    protected readonly WeakMap $observers;

    /** @var WeakMap<IWidget, IWidget> */
    protected readonly WeakMap $children;
    protected IInterval $interval;

    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
    ) {
        $this->observers = new WeakMap();
        $this->children = new WeakMap();
        $this->interval = $this->revolver->getInterval();
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        // TODO: Implement getFrame() method.
    }

    public function add(IWidget $widget): ILegacyWidgetContext
    {
        $this->assertNotSelf($widget);

        $context = $widget->getContext();

        $widget->attach($this);
        $this->children->offsetSet($widget, $context);

        $this->updateInterval($widget->getInterval());

        $this->notify();
        return $context;
    }

    protected function assertNotSelf(object $obj): void
    {
        if ($obj === $this) {
            throw new InvalidArgumentException('Object can not be self.');
        }
    }

    public function getContext(): ILegacyWidgetContext
    {
        // TODO: Implement getContext() method.
    }

    public function attach(SplObserver $observer): void
    {
        $this->assertNotSelf($observer);

        $this->observers->offsetSet($observer, $observer);
    }

    protected function updateInterval(IInterval $interval): void
    {
        $this->interval = $this->interval->smallest($interval);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function update(SplSubject $subject): void
    {
        if ($subject instanceof IWidget) {
            $this->updateInterval($subject->getInterval());
        }
    }

    public function remove(IWidget $widget): void
    {
        if (!$this->children->offsetExists($widget)) {
            return;
        }

        $this->children->offsetUnset($widget);
        foreach ($this->children as $child) {
            $this->updateInterval($child->getInterval());
        }
        $widget->detach($this);
        $this->notify();
    }

    public function detach(SplObserver $observer): void
    {
        if ($this->observers->offsetExists($observer)) {
            $this->observers->offsetUnset($observer);
        }
    }

    public function setContext(ILegacyWidgetContext $widgetContext): void
    {
        // TODO: Implement setContext() method.
    }
}
