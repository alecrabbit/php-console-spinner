<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ISequenceState;

final readonly class SequenceState implements ISequenceState
{
    public function __construct(
        private string $sequence,
        private int $width,
        private int $previousWidth,
    ) {
    }

    public function getSequence(): string
    {
        return $this->sequence;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getPreviousWidth(): int
    {
        return $this->previousWidth;
    }
}
