<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Widget\A\AWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;

final class WidgetComposite extends AWidget implements IWidgetComposite
{
    protected IInterval $interval;

    public function __construct(
        IWidgetRevolver $revolver,
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

        $this->interval = $this->widgetRevolver->getInterval();
        $this->children->attach($this);
        $this->update($this->children);
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    /** @inheritDoc */
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

    public function getFrame(?float $dt = null): IFrame
    {
        $frame = parent::getFrame($dt);

        if (!$this->children->isEmpty()) {
            /** @var IWidgetContext $childContext */
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

    public function remove(IWidgetContext $context): void
    {
        if ($this->children->has($context)) {
            $this->children->remove($context);
        }
    }
}
