<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntervalNormalizer;

abstract class AIntervalFactory extends ADefaultsAwareClass implements IIntervalFactory
{
    public static function createDefault(): IInterval
    {
        return
            new Interval(
                self::normalize(
                    self::getDefaults()->getIntervalMilliseconds()
                )
            );
    }

    protected static function normalize(int $i): int
    {
        return IntervalNormalizer::normalize($i);
    }

    public static function createNormalized(int $interval): IInterval
    {
        return new Interval(self::normalize($interval));
    }
}
