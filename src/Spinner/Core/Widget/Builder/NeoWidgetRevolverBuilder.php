<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Builder;

use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Widget\Contract\INeoWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\NeoWidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;

final class NeoWidgetRevolverBuilder implements INeoWidgetRevolverBuilder
{
    public function __construct(
        private ?IHasStyleSequenceFrame $style = null,
        private ?IHasCharSequenceFrame $char = null,
        private ?IInterval $interval = null,
    ) {
    }

    /** @inheritDoc */
    public function build(): IWidgetRevolver
    {
        match (true) {
            $this->style === null => throw new LogicException('Style is not set.'),
            $this->char === null => throw new LogicException('Char is not set.'),
            $this->interval === null => throw new LogicException('Interval is not set.'),
            default => null,
        };

        return new NeoWidgetRevolver(
            style: $this->style,
            char: $this->char,
            interval: $this->interval,
        );
    }

    public function withChar(IHasCharSequenceFrame $char): INeoWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->char = $char;
        return $clone;
    }

    public function withStyle(IHasStyleSequenceFrame $style): INeoWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->style = $style;
        return $clone;
    }

    public function withInterval(IInterval $interval): INeoWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }
}
