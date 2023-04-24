<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IObserverAndSubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use SplObserver;
use SplSubject;
use WeakMap;

final class Widget implements IObserverAndSubject
{
    protected readonly WeakMap $observers;
    protected readonly WeakMap $children;

    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
    ) {
        $this->observers = new WeakMap();
        $this->children = new WeakMap();
    }

    public function attach(SplObserver $observer): void
    {
        if ($observer === $this) {
            throw new InvalidArgumentException('Observer can not be self.');
        }

        $this->observers->offsetSet($observer, $observer);
    }

    public function detach(SplObserver $observer): void
    {
        if ($this->observers->offsetExists($observer)) {
            $this->observers->offsetUnset($observer);
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function update(SplSubject $subject): void
    {
        // FIXME (2023-04-24 15:33) [Alec Rabbit]: incomplete method
        $subject->getInterval();
    }

    public function getInterval(): IInterval
    {
        // TODO: Implement getInterval() method.
    }

    public function getFrame(?float $dt = null): IFrame
    {
        // TODO: Implement getFrame() method.
    }

    public function add(IWidgetComposite|IWidgetContext $element): IWidgetContext
    {
        $widget = $this->extractWidget($element);
        $context = $this->extractContext($element);

        $this->children->offsetSet($widget, $widget);
        $widget->attach($this);

        return $context;
    }

    public function remove(IWidgetComposite|IWidgetContext $element): void
    {
        // TODO: Implement remove() method.
    }

    public function getContext(): IWidgetContext
    {
        // TODO: Implement getContext() method.
    }

    public function setContext(IWidgetContext $widgetContext): void
    {
        // TODO: Implement setContext() method.
    }

    public function adoptBy(IWidgetComposite $widget): void
    {
        // TODO: Implement adoptBy() method.
    }

    public function makeOrphan(): void
    {
        // TODO: Implement makeOrphan() method.
    }

    public function updateInterval(): void
    {
        // TODO: Implement updateInterval() method.
    }

    private function extractContext(IWidgetComposite|IWidgetContext $element): IWidgetContext
    {
        if ($element instanceof IWidgetContext) {
            return $element;
        }

        return $element->getContext();
    }

    private function extractWidget(IWidgetComposite|IWidgetContext $element): IWidgetComposite
    {
        if ($element instanceof IWidgetComposite) {
            return $element;
        }

        return $element->getWidget();
    }
}
