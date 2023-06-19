<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\A\AWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;

final class WidgetComposite extends AWidget implements IWidgetComposite
{
    protected IInterval $interval;

    public function __construct(
        IRevolver $revolver,
        IFrame $leadingSpacer,
        IFrame $trailingSpacer,
        protected readonly IWidgetContextContainer $children = new WidgetContextContainer(),
        ?IWidgetContext $context = null,
    ) {
        parent::__construct(
            $revolver,
            $leadingSpacer,
            $trailingSpacer,
            $context
        );

        $this->interval = $this->revolver->getInterval();
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        $revolverFrame = $this->revolver->getFrame($dt);

        $frame = new CharFrame(
            $this->leadingSpacer->sequence() . $revolverFrame->sequence() . $this->trailingSpacer->sequence(),
            $this->leadingSpacer->width() + $revolverFrame->width() + $this->trailingSpacer->width()
        );

        if ($this->hasChildren()) {
            foreach ($this->children as $context) {
                $f = $context->getWidget()->getFrame($dt);
                $frame = new CharFrame(
                    $frame->sequence() . $f->sequence(),
                    $frame->width() + $f->width()
                );
            }
        }

        return $frame;
    }

    protected function hasChildren(): bool
    {
        return $this->children->count() > 0;
    }

    public function add(IWidgetComposite $widget): IWidgetContext
    {
        $widget->attach($this);

        $childContext = $this->children->add($widget->getContext());

        $this->stateUpdate();

        return $childContext;
    }


    private function stateUpdate(): void
    {
        $interval = $this->interval;
        $this->interval = $this->interval->smallest($this->children->getInterval() ?? $this->revolver->getInterval());
        if ($interval !== $this->interval) {
            $this->notify();
        }
    }

    /** @inheritdoc */
    public function update(ISubject $subject): void
    {
        $this->assertNotSelf($subject);

        if ($subject instanceof IHasInterval) {
            $this->interval = $this->interval->smallest($subject->getInterval());
        }
    }

    public function remove(IWidgetComposite $widget): void
    {
        $context = $widget->getContext();
        if ($this->children->has($context)) {
            $this->children->remove($context);

            $widget->detach($this);

            $this->stateUpdate();
        }
    }
}
