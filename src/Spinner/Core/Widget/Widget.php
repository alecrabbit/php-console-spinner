<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use SplObserver;
use SplSubject;
use WeakMap;

final class Widget implements IWidget
{
    /** @var WeakMap<IObserver, IObserver> */
    protected readonly WeakMap $observers;
    protected IInterval $interval;
    protected IWidgetContext $context;

    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
        protected readonly IWidgetContextContainer $children = new WidgetContextContainer(),
    ) {
        $this->interval = $this->revolver->getInterval();
        $this->context = new WidgetContext($this);

        $this->observers = new WeakMap();
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        // TODO: Implement getFrame() method.
    }

    public function add(IWidget $widget): IWidgetContext
    {
        $widget->attach($this);

        $context = $widget->getContext();
        $this->children->add($context);

        $this->updateState();
//        $this->updateInterval($widget->getInterval());
//        $this->notify();
        return $context;
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

    public function getContext(): IWidgetContext
    {
        // TODO: Implement getContext() method.
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
        $context = $widget->getContext();
        if ($this->children->has($context)) {
            $this->children->remove($context);

            $widget->detach($this);

            $this->updateState();
        }
    }

    public function detach(SplObserver $observer): void
    {
        if ($this->observers->offsetExists($observer)) {
            $this->observers->offsetUnset($observer);
        }
    }

    public function replaceContext(IWidgetContext $context): void
    {
        $this->context = $context;
    }

    private function updateState(): void
    {
        $interval = $this->interval;
//        $this->interval = $this->children->getIntervalContainer()->getSmallest();
        if ($interval !== $this->interval) {
            $this->notify();
        }
    }
}
