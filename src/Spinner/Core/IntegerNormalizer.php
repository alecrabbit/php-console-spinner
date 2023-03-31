<?php

declare(strict_types=1);
// 14.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class IntegerNormalizer implements IIntegerNormalizer
{
    protected const DEFAULT_DIVISOR = 1;
    protected const DEFAULT_MIN = 0;
    protected const MAX_DIVISOR = 1000000;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        protected int $divisor = self::DEFAULT_DIVISOR,
        protected int $min = self::DEFAULT_MIN,
    ) {
        self::assertDivisor($divisor);
        self::assertMin($min);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertDivisor(int $divisor): void
    {
        match (true) {
            0 >= $divisor => throw new InvalidArgumentException('Divisor should be greater than 0.'),
            $divisor > self::MAX_DIVISOR => throw new InvalidArgumentException(
                sprintf('Divisor should be less than %s.', self::MAX_DIVISOR)
            ),
            default => null,
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertMin(int $min): void
    {
        if (0 > $min) {
            throw new InvalidArgumentException('Min should be greater than 0.');
        }
    }

    public function normalize(int $interval): int
    {
        $result = (int)round($interval / $this->divisor) * $this->divisor;

        if ($this->min > $result) {
            return $this->min;
        }

        return $result;
    }
}
