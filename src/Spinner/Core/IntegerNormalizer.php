<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizer;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final class IntegerNormalizer implements IIntegerNormalizer
{
    private const DEFAULT_DIVISOR = 1;
    private const DEFAULT_MIN = 0;
    private const MAX_DIVISOR = 1000000;

    /**
     * @throws InvalidArgument
     */
    public function __construct(
        protected int $divisor = self::DEFAULT_DIVISOR,
        protected int $min = self::DEFAULT_MIN,
    ) {
        self::assertDivisor($divisor);
        self::assertMin($min);
    }

    /**
     * @throws InvalidArgument
     */
    private static function assertDivisor(int $divisor): void
    {
        match (true) {
            0 >= $divisor => throw new InvalidArgument('Divisor should be greater than 0.'),
            $divisor > self::MAX_DIVISOR => throw new InvalidArgument(
                sprintf('Divisor should be less than %s.', self::MAX_DIVISOR)
            ),
            default => null,
        };
    }

    /**
     * @throws InvalidArgument
     */
    private static function assertMin(int $min): void
    {
        if (0 > $min) {
            throw new InvalidArgument('Min should be greater than 0.');
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
