<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final readonly class Interval implements IInterval
{
    private float $milliseconds;

    /**
     * @throws InvalidArgument
     */
    public function __construct(?float $milliseconds = null)
    {
        $this->milliseconds = (float)($milliseconds ?? self::default());
        self::assert($this);
    }

    private static function default(): int|float
    {
        return self::max();
    }

    private static function max(): int|float
    {
        return self::MAX_INTERVAL_MILLISECONDS;
    }

    /**
     * @throws InvalidArgument
     */
    private static function assert(self $interval): void
    {
        match (true) {
            $interval->milliseconds < self::min() => throw new InvalidArgument(
                sprintf(
                    'Interval should be greater than or equal to %s.',
                    self::min()
                )
            ),
            $interval->milliseconds > self::max() => throw new InvalidArgument(
                sprintf(
                    'Interval should be less than or equal to %s.',
                    self::max()
                )
            ),
            default => null,
        };
    }

    private static function min(): int|float
    {
        return self::MIN_INTERVAL_MILLISECONDS;
    }

    public function toSeconds(): float
    {
        return $this->milliseconds / 1000;
    }

    public function toMicroseconds(): float
    {
        return $this->milliseconds * 1000;
    }

    public function toMilliseconds(): float
    {
        return $this->milliseconds;
    }
}
