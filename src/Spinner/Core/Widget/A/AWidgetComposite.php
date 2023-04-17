<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\WidgetContext;
use WeakMap;

abstract class AWidgetComposite implements IWidgetComposite
{
    protected IWidgetContext $context;
    /** @var array<IWidgetContext> */
    protected array $children = [];
    protected int $childrenCount = 0;
    protected ?IWidgetComposite $parent = null;
    protected WeakMap $childrenContextMap;
    protected int $childIndex = 0;

    public function __construct(
        protected readonly IRevolver $revolver,
        protected readonly IFrame $leadingSpacer,
        protected readonly IFrame $trailingSpacer,
    ) {
        $this->initialize();
    }

    protected function initialize(): void
    {
        $this->context = new WidgetContext($this);
        $this->childrenContextMap = new WeakMap();
    }

    public function update(?float $dt = null): IFrame
    {
        $revolverFrame = $this->revolver->update($dt);

        $frame = new Frame(
            $this->leadingSpacer->sequence() . $revolverFrame->sequence() . $this->trailingSpacer->sequence(),
            $this->leadingSpacer->width() + $revolverFrame->width() + $this->trailingSpacer->width()
        );

        if ($this->isComposite()) {
            foreach ($this->children as $context) {
                $f = $context->getWidget()->update($dt);
                $frame = new Frame(
                    $frame->sequence() . $f->sequence(),
                    $frame->width() + $f->width()
                );
            }
        }

        return $frame;
    }

    protected function isComposite(): bool
    {
        return 0 < $this->childrenCount;
    }

    public function add(IWidgetComposite|IWidgetContext $element): IWidgetContext
    {
        $widgetContext = $this->extractContext($element);
        $widget = $this->extractWidget($element);

        $this->children[$this->childIndex] = $widgetContext;
        $this->childrenContextMap[$widgetContext] = $this->childIndex;
        $this->childIndex++;
        $this->childrenCount++;
        $widget->adoptBy($this);
        $this->updateInterval();
        return $widgetContext;
    }

    protected function extractContext(IWidgetComposite|IWidgetContext $element): IWidgetContext
    {
        if ($element instanceof IWidgetComposite) {
            return $element->getContext();
        }
        return $element;
    }

    public function getContext(): IWidgetContext
    {
        return $this->context;
    }

    public function setContext(IWidgetContext $widgetContext): void
    {
        $this->context = $widgetContext;
    }

    protected function extractWidget(IWidgetComposite|IWidgetContext $element): IWidgetComposite
    {
        if ($element instanceof IWidgetComposite) {
            return $element;
        }
        return $element->getWidget();
    }

    public function adoptBy(IWidgetComposite $widget): void
    {
        $this->parent = $widget;
    }

    public function updateInterval(): void
    {
        $interval = $this->revolver->getInterval();
        foreach ($this->children as $child) {
            $interval = $child->getWidget()->getInterval()->smallest($interval);
        }
        $this->revolver->setInterval($interval);
        if ($this->hasParent()) {
            $this->parent?->updateInterval();
        }
    }

    public function getInterval(): IInterval
    {
        return $this->revolver->getInterval();
    }

    protected function hasParent(): bool
    {
        return $this->parent !== null;
    }

    public function remove(IWidgetComposite|IWidgetContext $element): void
    {
        $widgetContext = $this->extractContext($element);

        if ($this->childrenContextMap->offsetExists($widgetContext)) {
            /** @var int $index */
            $index = $this->childrenContextMap[$widgetContext];
            unset($this->children[$index]);
            $this->childrenContextMap->offsetUnset($widgetContext);
            $this->childrenCount--;
            $widget = $this->extractWidget($element);
            $widget->makeOrphan();
            $this->updateInterval();
        }
    }

    public function makeOrphan(): void
    {
        $this->parent = null;
    }
}
