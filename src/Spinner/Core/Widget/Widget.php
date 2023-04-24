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

    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
    ) {
        $this->observers = new WeakMap();
    }

    public function attach(SplObserver $observer): void
    {
        if ($observer === $this) {
            throw new InvalidArgumentException('Observer can not be self.');
        }

        // code below does not update $this->observers object "pointer"
        /** @noinspection PhpSecondWriteToReadonlyPropertyInspection */
        $this->observers[$observer] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        unset($this->observers[$observer]);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function update(SplSubject $subject): void
    {
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
        // TODO: Implement add() method.
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
}
