<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\ISequenceFrame;

abstract readonly class ASequenceFrame implements ISequenceFrame
{
    public function __construct(
        protected string $sequence,
        protected int $width,
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
}
