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
        $this->leadingSpacer = $this->refineLeadingSpacer(
            new WidgetFrame($leadingSpacer, WidthDefiner::define($leadingSpacer))
        );
        $this->trailingSpacer = $this->refineTrailingSpacer(
            new WidgetFrame($trailingSpacer, WidthDefiner::define($trailingSpacer))
        );
    }

    private function refineLeadingSpacer(AWidgetFrame $leadingSpacer): AWidgetFrame
    {
        $minWidth = $this->parent instanceof IWidget ? 1 : 0;
//        if($this->style->leadingSpacerWidth > $minWidth) {
//            $minWidth = $this->style->leadingSpacerWidth;
//        }
        if ($leadingSpacer->width < $minWidth) {
            return new WidgetFrame(str_repeat(C::SPACE_CHAR, $minWidth), WidthDefiner::define($minWidth));
        }
        return $leadingSpacer;
    }

    private function refineTrailingSpacer(AWidgetFrame $trailingSpacer): AWidgetFrame
    {
        $minWidth = 0;
//        if($this->style->leadingSpacerWidth > $minWidth) {
//            $minWidth = $this->style->leadingSpacerWidth;
//        }
        if ($trailingSpacer->width < $minWidth) {
            return new WidgetFrame(str_repeat(C::SPACE_CHAR, $minWidth), WidthDefiner::define($minWidth));
        }
        return $trailingSpacer;
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
