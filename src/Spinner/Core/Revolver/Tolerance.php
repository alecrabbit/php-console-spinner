<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Core\Contract\ITolerance;

final readonly class Tolerance implements ITolerance
{
    public function __construct(
        protected int $value = self::DEFAULT_VALUE
    ) {
    }

    public function toMilliseconds(): int
    {
        return $this->value;
    }
}
