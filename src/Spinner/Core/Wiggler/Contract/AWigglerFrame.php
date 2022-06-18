<?php

declare(strict_types=1);
// 13.06.22
namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrame;

abstract class AWigglerFrame implements IFrame
{
    public function __construct(
        protected readonly string $sequence,
        protected readonly int $width,
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
