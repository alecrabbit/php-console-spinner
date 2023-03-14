<?php

declare(strict_types=1);
// 14.03.23
namespace AlecRabbit\Spinner\Core;


use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;

final class IntervalNormalizer implements IIntervalNormalizer
{
    protected const DEFAULT_DIVISOR = 50;
    protected static int $divisor = self::DEFAULT_DIVISOR;

    public static function normalize(int $interval): int
    {
        return (int)round($interval / self::$divisor) * self::$divisor;
    }

    public static function setDivisor(int $divisor): void
    {
        self::$divisor = $divisor;
    }
}