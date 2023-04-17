<?php

declare(strict_types=1);

// 10.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISpinnerState;

final readonly class SpinnerState implements ISpinnerState
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
}
