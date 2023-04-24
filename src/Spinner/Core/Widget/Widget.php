<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetObserverAndSubject;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use SplObserver;
use SplSubject;
use WeakMap;

final class Widget implements IWidgetObserverAndSubject
{
    /** @var WeakMap<SplObserver, SplObserver> */
    protected readonly WeakMap $observers;

    /** @var WeakMap<IWidgetObserverAndSubject, IWidgetObserverAndSubject> */
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

    public function detach(SplObserver $observer): void
    {
        if ($this->observers->offsetExists($observer)) {
            $this->observers->offsetUnset($observer);
        }
    }

    public function getFrame(?float $dt = null): IFrame
    {
        // TODO: Implement getFrame() method.
    }

    public function add(IWidgetObserverAndSubject $element): IWidgetContext
    {
        $this->assertNotSelf($element);
        $element->attach($this);
        $this->children->offsetSet($element, $element);

        $this->updateInterval($element->getInterval());

        $this->notify();
        return $element->getContext();
    }

    public function attach(SplObserver $observer): void
    {
        $this->assertNotSelf($observer);

        $this->observers->offsetSet($observer, $observer);
    }

    protected function assertNotSelf(object $obj): void
    {
        if ($obj === $this) {
            throw new InvalidArgumentException('Object can not be self.');
        }
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
        if ($subject instanceof IWidgetObserverAndSubject) {
            $this->updateInterval($subject->getInterval());
        }
    }

    public function getContext(): IWidgetContext
    {
        // TODO: Implement getContext() method.
    }

    public function remove(IWidgetObserverAndSubject $element): void
    {
        if (!$this->children->offsetExists($element)) {
            return;
        }

        $this->children->offsetUnset($element);
        foreach ($this->children as $child) {
            $this->updateInterval($child->getInterval());
        }
        $element->detach($this);
        $this->notify();
    }

    public function setContext(IWidgetContext $widgetContext): void
    {
        // TODO: Implement setContext() method.
    }
}
