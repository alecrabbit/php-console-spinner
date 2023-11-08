<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IPoint;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Exception\NotImplemented;

final readonly class SequenceState implements ISequenceState
{
    public function __construct(
        protected string $sequence = '',
        protected int $width = 0,
        protected int $previousWidth = 0,
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

    public function getPosition(): IPoint
    {
        throw new NotImplemented('Not implemented in this package.');
    }
}
