<?php

declare(strict_types=1);
// 14.03.23
namespace AlecRabbit\Spinner\Core;


use AlecRabbit\Spinner\Core\Contract\IIntNormalizer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class IntNormalizer implements IIntNormalizer
{
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
            throw new InvalidArgumentException(
                sprintf('Divisor should be less than %s.', self::MAX_DIVISOR)
            );
        }
    }

    public static function getDivisor(): int
    {
        return self::$divisor;
    }
}