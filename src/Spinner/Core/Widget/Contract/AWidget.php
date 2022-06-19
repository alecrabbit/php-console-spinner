<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Contract\AFrame;
use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Rotor\Contract\IFrameRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\WidthDefiner;
use AlecRabbit\Spinner\Core\Wiggler\Frame;
use WeakMap;

abstract class AWidget implements IWidget
{
    protected WeakMap $children;
    protected ?IWidget $parent = null;
    protected readonly AFrame $leadingSpacer;
    protected readonly AFrame $trailingSpacer;

    public function __construct(
        protected readonly IStyleRotor $style,
        protected readonly IFrameRotor $rotor,
        string $leadingSpacer = C::EMPTY_STRING,
        string $trailingSpacer = C::EMPTY_STRING,
    ) {
        $this->children = new WeakMap();
        $this->leadingSpacer = $this->refineLeadingSpacer(
            new Frame($leadingSpacer, WidthDefiner::define($leadingSpacer))
        );
        $this->trailingSpacer = $this->refineTrailingSpacer(
            new Frame($trailingSpacer, WidthDefiner::define($trailingSpacer))
        );
    }

    private function refineLeadingSpacer(AFrame $leadingSpacer): AFrame
    {
        $minWidth = $this->parent instanceof IWidget ? 1 : 0;
//        if($this->style->leadingSpacerWidth > $minWidth) {
//            $minWidth = $this->style->leadingSpacerWidth;
//        }
        if ($leadingSpacer->getWidth() < $minWidth) {
            return new Frame(str_repeat(C::SPACE_CHAR, $minWidth), WidthDefiner::define($minWidth));
        }
        return $leadingSpacer;
    }

    private function refineTrailingSpacer(AFrame $trailingSpacer): AFrame
    {
        $minWidth = 0;
//        if($this->style->leadingSpacerWidth > $minWidth) {
//            $minWidth = $this->style->leadingSpacerWidth;
//        }
        if ($trailingSpacer->getWidth() < $minWidth) {
            return new Frame(str_repeat(C::SPACE_CHAR, $minWidth), WidthDefiner::define($minWidth));
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

    public function render(?IInterval $interval = null): AFrame
    {
        $childrenFrame = $this->renderChildren($interval);
        return
            new Frame(
                $this->createSequence($interval) . $childrenFrame->getSequence(),
                $this->rotor->getWidth()
                + $childrenFrame->getWidth()
                + $this->leadingSpacer->getWidth()
                + $this->trailingSpacer->getWidth()
            );
    }

    private function renderChildren(?IInterval $interval = null): AFrame
    {
        $sequence = '';
        $width = 0;

        foreach ($this->children as $child) {
            $frame = $child->render($interval);
            $sequence .= $frame->getSequence();
            $width += $frame->getWidth();
        }

        return
            new Frame(
                $sequence,
                $width
            );
    }

    protected function createSequence(): string
    {
        return
            $this->style->join(
                chars: $this->leadingSpacer->getSequence() . $this->rotor->next() . $this->trailingSpacer->getSequence(),
            );
    }

    public function isComposite(): bool
    {
        return 0 < count($this->children);
    }

}
