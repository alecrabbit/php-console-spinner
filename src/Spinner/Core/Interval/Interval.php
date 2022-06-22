<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Interval;

use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

final class Interval implements IInterval
{
    private int|float $milliseconds;

    public function __construct(null|int|float $milliseconds)
    {
        $this->milliseconds = $milliseconds ?? self::maxInterval();
    }

    private static function maxInterval(): int|float
    {
        return Defaults::getMaxIntervalMilliseconds();
    }

    public function toMilliseconds(): float|int
    {
        return $this->milliseconds;
    }

    public function toSeconds(): float|int
    {
        return $this->milliseconds / 1000;
    }

    public static function createDefault(): IInterval
    {
        return new self(null);
    }
}
