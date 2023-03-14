<?php

declare(strict_types=1);
// 14.03.23
namespace AlecRabbit\Spinner\Core;


use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class IntervalNormalizer implements IIntervalNormalizer
{
    private const DEFAULT_DIVISOR = 50;
    private const MAX_DIVISOR = 1000;
    private static int $divisor = self::DEFAULT_DIVISOR;

    public static function normalize(int $interval): int
    {
        return (int)round($interval / self::$divisor) * self::$divisor;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function setDivisor(int $divisor): void
    {
        self::assertDivisor($divisor);
        self::$divisor = $divisor;
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertDivisor(int $divisor): void
    {
        if (0 >= $divisor) {
            throw new InvalidArgumentException('Divisor should be greater than 0.');
        }
        if (self::MAX_DIVISOR < $divisor) {
            throw new InvalidArgumentException('Divisor should be less than 1000.');
        }
    }
}