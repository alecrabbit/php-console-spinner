<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\A\AWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

final class WidgetComposite extends AWidget implements IWidgetComposite
{
    protected IInterval $interval;

    public function __construct(
        IRevolver $revolver,
        IFrame $leadingSpacer,
        IFrame $trailingSpacer,
        protected readonly IWidgetCompositeChildrenContainer $children = new WidgetCompositeChildrenContainer(),
        ?IObserver $observer = null,
    ) {
        parent::__construct(
            $revolver,
            $leadingSpacer,
            $trailingSpacer,
            $observer
        );

        $this->interval = $this->revolver->getInterval();
        $this->children->attach($this);
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        $frame = parent::getFrame($dt);

        if (!$this->children->isEmpty()) {
            /** @var  $childContext IWidgetContext */
            foreach ($this->children as $childContext => $_) {
                $widget = $childContext->getWidget();
                if ($widget instanceof IWidget) {
                    $f = $widget->getFrame($dt);
                    $frame = new CharFrame(
                        $frame->sequence() . $f->sequence(),
                        $frame->width() + $f->width()
                    );
                }
            }
        }

        return $frame;
    }

    public function add(IWidgetContext $context): IWidgetContext
    {
        return
            $this->children->add($context);
    }

    /** @inheritdoc */
    public function update(ISubject $subject): void
    {
        $this->assertNotSelf($subject);

        if ($subject === $this->children) {
            $interval = $this->interval->smallest($subject->getInterval());
            if ($interval !== $this->interval) {
                $this->interval = $interval;
                $this->notify();
            }
        }
    }

    public function remove(IWidgetContext $context): void
    {
        if ($this->children->has($context)) {
            $this->children->remove($context);
        }
    }
//
//    private function stateUpdate(): void
//    {
//        $interval = $this->interval;
//        $this->interval = $this->interval->smallest($this->children->getInterval() ?? $this->revolver->getInterval());
//        if ($interval !== $this->interval) {
//            $this->notify();
//        }
//    }
}
