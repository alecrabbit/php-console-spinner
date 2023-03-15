<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\I\IFrame;

abstract readonly class AFrame implements IFrame
{
    public function __construct(
        protected string $sequence,
        protected int $width,
    ) {
    }

    public function sequence(): string
    {
        return $this->sequence;
    }

    public function width(): int
    {
        return $this->width;
    }
}
