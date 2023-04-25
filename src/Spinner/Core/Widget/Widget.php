<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use SplObserver;
use SplSubject;

final class Widget implements IWidget
{
    protected IInterval $interval;
    protected IWidgetContext $context;

    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
        protected readonly IWidgetContextContainer $children = new WidgetContextContainer(),
        protected ?IObserver $observer = null,
    ) {
        $this->interval = $this->revolver->getInterval();
        $this->context = new WidgetContext($this);
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

        $this->stateUpdate();

        return $context;
    }

    public function attach(SplObserver $observer): void
    {
        if ($this->observer !== null) {
            throw new InvalidArgumentException('Observer is already attached.');
        }

        $this->assertNotSelf($observer);

        $this->observer = $observer;
    }

    protected function assertNotSelf(object $obj): void
    {
        if ($obj === $this) {
            throw new InvalidArgumentException('Object can not be self.');
        }
    }

    public function getContext(): IWidgetContext
    {
        return $this->context;
    }

    private function stateUpdate(): void
    {
        $interval = $this->interval;
        $this->interval = $this->children->getIntervalContainer()->getSmallest();
        if ($interval !== $this->interval) {
            $this->notify();
        }
    }

    public function notify(): void
    {
        $this->observer->update($this);
    }

    public function update(SplSubject $subject): void
    {
        $this->assertNotSelf($subject);

        if ($subject instanceof IHasInterval) {
            $this->interval = $this->interval->smallest($subject->getInterval());
        }
    }

    public function remove(IWidget $widget): void
    {
        $context = $widget->getContext();
        if ($this->children->has($context)) {
            $this->children->remove($context);

            $widget->detach($this);

            $this->stateUpdate();
        }
    }

    public function detach(SplObserver $observer): void
    {
        if ($this->observer === $observer) {
            $this->observer = null;
        }
    }

    public function replaceContext(IWidgetContext $context): void
    {
        if ($context->getWidget() !== $this) {
            throw new InvalidArgumentException('Context is not related to this widget.');
        }
        $this->context = $context;
    }
}
