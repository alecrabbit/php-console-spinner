<?php
declare(strict_types=1);
// 14.03.23
namespace AlecRabbit\Spinner\Core\Contract;

interface IIntervalNormalizer
{
    public static function normalize(int $interval): int;
}