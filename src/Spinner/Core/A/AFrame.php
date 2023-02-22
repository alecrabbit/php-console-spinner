<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;

abstract readonly class AFrame implements IFrame
{
    public function __construct(
        protected string $sequence,
        protected int $width,
    ) {
    }

    public static function createEmpty(): static
    {
        return new static('', 0);
    }

    public static function createSpace(): static
    {
        return new static(' ', 1);
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
