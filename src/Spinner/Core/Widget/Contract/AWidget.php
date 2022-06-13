<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Rotor\Contract\IFrameRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Widget\WidgetFrame;
use WeakMap;

abstract class AWidget implements IWidget
{
    protected WeakMap $children;
    protected ?IWidget $parent = null;

    public function __construct(
        protected readonly IStyleRotor $style,
        protected readonly IFrameRotor $rotor,
    ) {
        $this->children = new WeakMap();
    }

    public function add(IWidget $widget): static
    {
        $this->children[$widget] = $widget;
        $widget->parent($this);
        return $this;
    }

    public function parent(?IWidget $widget): void
    {
        $this->parent = $widget;
    }

    public function remove(IWidget $widget): static
    {
        unset($this->children[$widget]);
        $widget->parent(null);
        return $this;
    }

    public function render(?IInterval $interval = null): AWidgetFrame
    {
        $childrenFrame = $this->renderChildren($interval);
        return
            new WidgetFrame(
                $this->createSequence($interval) . $childrenFrame->sequence,
                $this->rotor->getWidth() + $childrenFrame->sequenceWidth
            );
    }

    private function renderChildren(?IInterval $interval = null): AWidgetFrame
    {
        $sequence = '';
        $width = 0;

        foreach ($this->children as $child) {
            $frame = $child->render($interval);
            $sequence .= $frame->sequence;
            $width += $frame->sequenceWidth;
        }

        return
            new WidgetFrame(
                $sequence,
                $width
            );
    }

    public function isComposite(): bool
    {
        return 0 < count($this->children);
    }

    protected function createSequence(?IInterval $interval = null): string
    {
        return
            $this->style->join(
                chars: $this->rotor->next($interval),
                interval: $interval,
            );
    }

}
