<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Frame\Contract;

use Stringable;

abstract class ACharFrame implements ICharFrame,
                                     Stringable
{
    public function __construct(
        protected readonly string $charSequence,
        protected readonly int $width,
    ) {
    }

    public static function createEmpty(): static
    {
        return new static('', 0);
    }

    public static function create(string $char, int $width): static
    {
        return new static($char, $width);
    }

    public static function createSpace(): static
    {
        return new static(' ', 1);
    }

    public function __toString(): string
    {
        return $this->charSequence;
    }

    public function getCharSequence(): string
    {
        return $this->charSequence;
    }

    public function getWidth(): int
    {
        return $this->width;
    }
}
