<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

final class Interval implements IInterval
{
    private const MAX_INTERVAL = Defaults::MILLISECONDS_MAX_INTERVAL;
    private readonly int|float $seconds;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        null|int|float $milliseconds,
    ) {
        self::assert($milliseconds);
        $this->seconds = ($milliseconds ?? Defaults::MILLISECONDS_INTERVAL) / 1000;
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assert(null|int|float $milliseconds): void
    {
        if (null === $milliseconds) {
            return;
        }
        if (0.0 >= (float)$milliseconds) {
            throw new InvalidArgumentException('Interval should be greater than 0.');
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
        return (float)$this->seconds;
    }
}


