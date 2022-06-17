<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Rotor\Contract\IFrameRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Widget\WigglerFrame;
use AlecRabbit\Spinner\Core\WidthDefiner;
use WeakMap;

abstract class AWidget implements IWidget
{
    protected WeakMap $children;
    protected ?IWidget $parent = null;
    protected readonly AWigglerFrame $leadingSpacer;
    protected readonly AWigglerFrame $trailingSpacer;

    public function __construct(
        protected readonly IStyleRotor $style,
        protected readonly IFrameRotor $rotor,
        string $leadingSpacer = C::EMPTY_STRING,
        string $trailingSpacer = C::EMPTY_STRING,
    ) {
        $this->children = new WeakMap();
        $this->leadingSpacer = $this->refineLeadingSpacer(
            new WigglerFrame($leadingSpacer, WidthDefiner::define($leadingSpacer))
        );
        $this->trailingSpacer = $this->refineTrailingSpacer(
            new WigglerFrame($trailingSpacer, WidthDefiner::define($trailingSpacer))
        );
    }

    private function refineLeadingSpacer(AWigglerFrame $leadingSpacer): AWigglerFrame
    {
        $minWidth = $this->parent instanceof IWidget ? 1 : 0;
//        if($this->style->leadingSpacerWidth > $minWidth) {
//            $minWidth = $this->style->leadingSpacerWidth;
//        }
        if ($leadingSpacer->width < $minWidth) {
            return new WigglerFrame(str_repeat(C::SPACE_CHAR, $minWidth), WidthDefiner::define($minWidth));
        }
        return $leadingSpacer;
    }

    private function refineTrailingSpacer(AWigglerFrame $trailingSpacer): AWigglerFrame
    {
        $minWidth = 0;
//        if($this->style->leadingSpacerWidth > $minWidth) {
//            $minWidth = $this->style->leadingSpacerWidth;
//        }
        if ($trailingSpacer->width < $minWidth) {
            return new WigglerFrame(str_repeat(C::SPACE_CHAR, $minWidth), WidthDefiner::define($minWidth));
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

    public function render(?IInterval $interval = null): AWigglerFrame
    {
        $childrenFrame = $this->renderChildren($interval);
        return
            new WigglerFrame(
                $this->createSequence($interval) . $childrenFrame->sequence,
                $this->rotor->getWidth()
                + $childrenFrame->width
                + $this->leadingSpacer->width
                + $this->trailingSpacer->width
            );
    }

    private function renderChildren(?IInterval $interval = null): AWigglerFrame
    {
        $sequence = '';
        $width = 0;

        foreach ($this->children as $child) {
            $frame = $child->render($interval);
            $sequence .= $frame->sequence;
            $width += $frame->width;
        }

        return
            new WigglerFrame(
                $sequence,
                $width
            );
    }

    protected function createSequence(?IInterval $interval = null): string
    {
        return
            $this->style->join(
                chars: $this->leadingSpacer->sequence . $this->rotor->next($interval) . $this->trailingSpacer->sequence,
            );
    }

    public function isComposite(): bool
    {
        return 0 < count($this->children);
    }

}
