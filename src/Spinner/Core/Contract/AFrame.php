<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Contract;

abstract class AFrame implements IFrame
{
    public function __construct(
        protected readonly string $sequence,
        protected readonly int $width,
    ) {
    }

    public function __toString(): string
    {
        return $this->sequence;
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
