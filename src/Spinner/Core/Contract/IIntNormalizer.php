<?php

declare(strict_types=1);
// 14.03.23
namespace AlecRabbit\Spinner\Core\Contract;

interface IIntNormalizer
{
    final public const DEFAULT_DIVISOR = 50;

    final public const MAX_DIVISOR = 1000;

    public static function normalize(int $interval): int;

    public static function setDivisor(int $divisor): void;

    public static function getDivisor(): int;
}