<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Builder;

use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;

final class WidgetRevolverBuilder implements IWidgetRevolverBuilder
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

        return new WidgetRevolver(
            style: $this->style,
            char: $this->char,
            interval: $this->interval,
        );
    }

    public function withChar(IHasCharSequenceFrame $char): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->char = $char;
        return $clone;
    }

    public function withStyle(IHasStyleSequenceFrame $style): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->style = $style;
        return $clone;
    }

    public function withInterval(IInterval $interval): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }
}
