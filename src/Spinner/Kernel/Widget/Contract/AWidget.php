<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Kernel\Widget\Contract;

use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\ACharFrame;
use AlecRabbit\Spinner\Kernel\Contract\Base\C;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IFrameRotor;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\WIInterval;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Kernel\WidthDefiner;
use WeakMap;

abstract class AWidget implements IWidget
{
    protected WeakMap $children;
    protected ?IWidget $parent = null;
    protected readonly ACharFrame $leadingSpacer;
    protected readonly ACharFrame $trailingSpacer;

    public function __construct(
        protected readonly IStyleRotor $style,
        protected readonly IFrameRotor $rotor,
        string $leadingSpacer = C::EMPTY_STRING,
        string $trailingSpacer = C::EMPTY_STRING,
    ) {
        $this->children = new WeakMap();
        $this->leadingSpacer = $this->refineLeadingSpacer(
            new CharFrame($leadingSpacer, WidthDefiner::define($leadingSpacer))
        );
        $this->trailingSpacer = $this->refineTrailingSpacer(
            new CharFrame($trailingSpacer, WidthDefiner::define($trailingSpacer))
        );
    }

    private function refineLeadingSpacer(ACharFrame $leadingSpacer): ACharFrame
    {
        $minWidth = $this->parent instanceof IWidget ? 1 : 0;
//        if($this->style->leadingSpacerWidth > $minWidth) {
//            $minWidth = $this->style->leadingSpacerWidth;
//        }
        if ($leadingSpacer->getWidth() < $minWidth) {
            return new CharFrame(str_repeat(C::SPACE_CHAR, $minWidth), WidthDefiner::define($minWidth));
        }
        return $leadingSpacer;
    }

    private function refineTrailingSpacer(ACharFrame $trailingSpacer): ACharFrame
    {
        $minWidth = 0;
//        if($this->style->leadingSpacerWidth > $minWidth) {
//            $minWidth = $this->style->leadingSpacerWidth;
//        }
        if ($trailingSpacer->getWidth() < $minWidth) {
            return new CharFrame(str_repeat(C::SPACE_CHAR, $minWidth), WidthDefiner::define($minWidth));
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

    public function render(?WIInterval $interval = null): ACharFrame
    {
        $childrenFrame = $this->renderChildren($interval);
        return
            new CharFrame(
                $this->createSequence($interval) . $childrenFrame->getChar(),
                $this->rotor->getWidth()
                + $childrenFrame->getWidth()
                + $this->leadingSpacer->getWidth()
                + $this->trailingSpacer->getWidth()
            );
    }

    private function renderChildren(?WIInterval $interval = null): ACharFrame
    {
        $sequence = '';
        $width = 0;

        foreach ($this->children as $child) {
            $frame = $child->render($interval);
            $sequence .= $frame->getSequence();
            $width += $frame->getWidth();
        }

        return
            new CharFrame(
                $sequence,
                $width
            );
    }

    protected function createSequence(): string
    {
        return
            $this->style->join(
                chars: $this->leadingSpacer->getChar() . $this->rotor->next() . $this->trailingSpacer->getChar(),
            );
    }

    public function isComposite(): bool
    {
        return 0 < count($this->children);
    }

}
