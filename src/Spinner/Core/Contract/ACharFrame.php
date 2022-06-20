<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use Stringable;

abstract class ACharFrame implements ICharFrame,
                                     Stringable
{
    public function __construct(
        protected readonly string $char,
        protected readonly int $width,
    ) {
    }

    public function __toString(): string
    {
        return $this->char;
    }

    public function getChar(): string
    {
        return $this->char;
    }

    public function getWidth(): int
    {
        return $this->width;
    }
}
