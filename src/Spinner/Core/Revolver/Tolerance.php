<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class Tolerance implements ITolerance
{
    public function __construct(
        protected int $value = self::DEFAULT_VALUE
    ) {
        self::assertValue($value);
    }

    private static function assertValue(int $value): void
    {
        match (true) {
            $value < 0 => throw new InvalidArgument('Tolerance value must be positive integer.'),
            default => null,
        };
    }

    public function toMilliseconds(): int
    {
        return $this->value;
    }
}
