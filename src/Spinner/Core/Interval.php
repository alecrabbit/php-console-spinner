<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class Interval implements IInterval
{
    protected float $milliseconds;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(?float $milliseconds = null)
    {
        $this->milliseconds = (float)($milliseconds ?? self::default());
        self::assert($this);
    }

    protected static function default(): int|float
    {
        return self::max();
    }

    protected static function max(): int|float
    {
        return self::MAX_INTERVAL_MILLISECONDS;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function assert(self $interval): void
    {
        match (true) {
            $interval->milliseconds < self::min() =>
            throw new InvalidArgumentException(
                sprintf(
                    'Interval should be greater than or equal to %s.',
                    self::min()
                )
            ),
            $interval->milliseconds > self::max() =>
            throw new InvalidArgumentException(
                sprintf(
                    'Interval should be less than or equal to %s.',
                    self::max()
                )
            ),
            default => null,
        };
    }

    protected static function min(): int|float
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

    public function smallest(mixed $other): IInterval
    {
        if ($other instanceof IInterval && $this->milliseconds > $other->toMilliseconds()) {
            return $other;
        }
        return $this;
    }

    public function toMilliseconds(): float
    {
        return $this->milliseconds;
    }
}
