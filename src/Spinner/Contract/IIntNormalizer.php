<?php

declare(strict_types=1);
// 14.03.23
namespace AlecRabbit\Spinner\Contract;

interface IIntNormalizer
{
    final public const DEFAULT_DIVISOR = 50;
    final public const DEFAULT_MIN = 0;
    final public const MAX_DIVISOR = 1000;


    public static function normalize(int $interval): int;

    public static function setDivisor(int $divisor): void;

    public static function getDivisor(): int;

    public static function setMin(int $min): void;
}