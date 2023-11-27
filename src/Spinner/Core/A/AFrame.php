<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IFrame;

abstract readonly class AFrame implements IFrame
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
