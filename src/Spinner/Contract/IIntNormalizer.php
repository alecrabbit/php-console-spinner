<?php

declare(strict_types=1);
// 14.03.23

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IIntNormalizer
{
    final public const DEFAULT_DIVISOR = 1;
    final public const DEFAULT_MIN = 0;
    final public const MAX_DIVISOR = 1000000;

    public static function normalize(int $interval): int;

    /**
     * @throws InvalidArgumentException
     */
    public static function overrideDivisor(int $divisor): void;

    public static function getDivisor(): int;

    /**
     * @throws InvalidArgumentException
     */
    public static function overrideMin(int $min): void;
}
