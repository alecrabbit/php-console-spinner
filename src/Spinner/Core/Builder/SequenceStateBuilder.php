<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\SequenceState;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class SequenceStateBuilder implements ISequenceStateBuilder
{
    private ?string $sequence = null;
    private ?int $width = null;
    private ?int $previousWidth = null;

    public function withSequence(string $sequence): ISequenceStateBuilder
    {
        $clone = clone $this;
        $clone->sequence = $sequence;
        return $clone;
    }

    public function withWidth(int $width): ISequenceStateBuilder
    {
        $clone = clone $this;
        $clone->width = $width;
        return $clone;
    }

    public function withPreviousWidth(int $previousWidth): ISequenceStateBuilder
    {
        $clone = clone $this;
        $clone->previousWidth = $previousWidth;
        return $clone;
    }

    public function build(): ISequenceState
    {
        $this->validate();

        return new SequenceState(
            sequence: $this->sequence,
            width: $this->width,
            previousWidth: $this->previousWidth,
        );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->sequence === null => throw new LogicException('Sequence is not set.'),
            $this->width === null => throw new LogicException('Width is not set.'),
            $this->previousWidth === null => throw new LogicException('Previous width is not set.'),
            default => null,
        };
    }

    public function withSequenceFrame(ISequenceFrame $frame): ISequenceStateBuilder
    {
        $clone = clone $this;
        $clone->sequence = $frame->getSequence();
        $clone->width = $frame->getWidth();
        return $clone;
    }

    public function withPrevious(ISequenceState $previous): ISequenceStateBuilder
    {
        $clone = clone $this;
        $clone->previousWidth = $previous->getWidth();
        return $clone;
    }
}
