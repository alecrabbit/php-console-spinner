<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class Widget extends ASubject implements IWidget
{
    protected IInterval $interval;
    protected IWidgetContext $context;

    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
        protected readonly IWidgetContextContainer $children = new WidgetContextContainer(),
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->interval = $this->revolver->getInterval();
        $this->context = new WidgetContext($this);
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        $revolverFrame = $this->revolver->getFrame($dt);

        $frame = new Frame(
            $this->leadingSpacer->sequence() . $revolverFrame->sequence() . $this->trailingSpacer->sequence(),
            $this->leadingSpacer->width() + $revolverFrame->width() + $this->trailingSpacer->width()
        );

        if ($this->children->count() > 0) {
            foreach ($this->children as $context) {
                $f = $context->getWidget()->getFrame($dt);
                $frame = new Frame(
                    $frame->sequence() . $f->sequence(),
                    $frame->width() + $f->width()
                );
            }
        }

        return $frame;
    }

    public function add(IWidget $widget): IWidgetContext
    {
        $widget->attach($this);

        $context = $widget->getContext();

        $this->children->add($context);

        $this->stateUpdate();

        return $context;
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

    public function update(ISubject $subject): void
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

    public function replaceContext(IWidgetContext $context): void
    {
        if ($context->getWidget() !== $this) {
            throw new InvalidArgumentException('Context is not related to this widget.');
        }
        $this->context = $context;
    }
}
