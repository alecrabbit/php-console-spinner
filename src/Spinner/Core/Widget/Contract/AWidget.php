<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Rotor\Contract\IFrameRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Widget\WidgetFrame;
use AlecRabbit\Spinner\Core\WidthDefiner;
use WeakMap;

abstract class AWidget implements IWidget
{
    protected WeakMap $children;
    protected ?IWidget $parent = null;
    protected readonly AWidgetFrame $leadingSpacer;
    protected readonly AWidgetFrame $trailingSpacer;

    public function __construct(
        protected readonly IStyleRotor $style,
        protected readonly IFrameRotor $rotor,
        string $leadingSpacer = C::EMPTY_STRING,
        string $trailingSpacer = C::EMPTY_STRING,
    ) {
        $this->children = new WeakMap();
        $this->leadingSpacer = $this->refineLeadingSpacer($leadingSpacer);
        $this->trailingSpacer = $this->refineTrailingSpacer($trailingSpacer);
    }

    private function refineLeadingSpacer(string $leadingSpacer): AWidgetFrame
    {
        return new WidgetFrame($leadingSpacer, WidthDefiner::define($leadingSpacer));
    }

    private function refineTrailingSpacer(string $trailingSpacer): AWidgetFrame
    {
        return new WidgetFrame($trailingSpacer, WidthDefiner::define($trailingSpacer));
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
                $this->rotor->getWidth()
                + $childrenFrame->width
                + $this->leadingSpacer->width
                + $this->trailingSpacer->width
            );
    }

    private function renderChildren(?IInterval $interval = null): AWidgetFrame
    {
        $sequence = '';
        $width = 0;

        foreach ($this->children as $child) {
            $frame = $child->render($interval);
            $sequence .= $frame->sequence;
            $width += $frame->width;
        }

        return
            new WidgetFrame(
                $sequence,
                $width
            );
    }

    protected function createSequence(?IInterval $interval = null): string
    {
        return
            $this->style->join(
                chars: $this->leadingSpacer->sequence . $this->rotor->next($interval) . $this->trailingSpacer->sequence,
                interval: $interval,
            );
    }

    public function isComposite(): bool
    {
        return 0 < count($this->children);
    }

}
