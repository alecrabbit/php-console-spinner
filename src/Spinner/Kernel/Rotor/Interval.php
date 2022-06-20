<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Kernel\Rotor;

use AlecRabbit\Spinner\Kernel\Contract\Base\Defaults;
use AlecRabbit\Spinner\Kernel\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IInterval;

final class Interval implements IInterval
{
    private const MAX_INTERVAL = Defaults::MILLISECONDS_MAX_INTERVAL;
    private const MIN_INTERVAL = Defaults::MILLISECONDS_MIN_INTERVAL;
    private readonly int|float $seconds;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        null|int|float $milliseconds = null,
    ) {
        self::assert($milliseconds);
        $this->seconds = (float)(($milliseconds ?? Defaults::MILLISECONDS_INTERVAL) / 1000);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assert(null|int|float $milliseconds): void
    {
        if (null === $milliseconds) {
            return;
        }
        if ((float)self::MIN_INTERVAL >= (float)$milliseconds) {
            throw new InvalidArgumentException(
                sprintf(
                    'Interval should be greater than %s.',
                    self::MIN_INTERVAL
                )
            );
        }
        if (self::MAX_INTERVAL < $milliseconds) {
            throw new InvalidArgumentException(
                sprintf(
                    'Interval should be less than %d.',
                    self::MAX_INTERVAL
                )
            );
        }
    }

    public function toSeconds(): float
    {
        return $this->seconds;
    }

    public function smallest(?IInterval $other): ?IInterval
    {
        if (null === $other) {
            return $this;
        }
        if ($this->seconds < $other->seconds) {
            return $this;
        }
        return $other;
    }
}


