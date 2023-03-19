<?php

declare(strict_types=1);
// 14.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IIntNormalizer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class IntNormalizer implements IIntNormalizer
{
    private static int $divisor = self::DEFAULT_DIVISOR;
    private static int $min = self::DEFAULT_MIN;

    public static function normalize(int $interval): int
    {
        $result = (int)round($interval / self::$divisor) * self::$divisor;

        if (self::$min > $result) {
            $result = self::$min;
        }

        return $result;
    }

    public static function getDivisor(): int
    {
        return self::$divisor;
    }


    /** @inheritdoc  */
    public static function overrideDivisor(int $divisor): void
    {
        self::assertDivisor($divisor);
        self::$divisor = $divisor;
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

    /** @inheritdoc  */

    public static function overrideMin(int $min): void
    {
        self::assertMin($min);
        self::$min = $min;
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
}
