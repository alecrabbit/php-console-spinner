<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Interval;

use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class Interval implements IInterval
{
    private static null|float|int $minInterval = null;
    private static null|float|int $maxInterval = null;
    private int|float $milliseconds;

    public function __construct(null|int|float $milliseconds)
    {
        $this->milliseconds = (float)($milliseconds ?? self::maxInterval());
        self::assert($this);
    }

    private static function maxInterval(): int|float
    {
        if (null === self::$maxInterval) {
            self::$maxInterval = Defaults::getMaxIntervalMilliseconds();
        }
        return self::$maxInterval;
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assert(Interval $interval): void
    {
        match (true) {
            $interval->milliseconds < self::minInterval() =>
            throw new InvalidArgumentException(
                sprintf(
                    'Interval should be greater than %s.',
                    self::minInterval()
                )
            ),
            $interval->milliseconds > self::maxInterval() =>
            throw new InvalidArgumentException(
                sprintf(
                    'Interval should be less than %s.',
                    self::maxInterval()
                )
            ),
            true => null,
        };
    }

    private static function minInterval(): float|int
    {
        if (null === self::$minInterval) {
            self::$minInterval = Defaults::getMinIntervalMilliseconds();
        }
        return self::$minInterval;
    }

    public static function createDefault(): IInterval
    {
        return new self(null);
    }

    public function toMilliseconds(): float
    {
        return $this->milliseconds;
    }

    public function toSeconds(): float
    {
        return (float)($this->milliseconds / 1000);
    }
}
