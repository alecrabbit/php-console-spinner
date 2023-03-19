<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntNormalizer;

abstract class AIntervalFactory extends ADefaultsAwareClass implements IIntervalFactory
{
    protected static NormalizerMode $normalizerMode = self::NORMALIZER_MODE;

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
        return IntNormalizer::normalize($i);
    }

    public static function createNormalized(int $interval): IInterval
    {
        return new Interval(self::normalize($interval));
    }

    public static function overrideNormalizerMode(NormalizerMode $mode): void
    {
        self::$normalizerMode = $mode;
        IntNormalizer::overrideDivisor($mode->getDivisor());
    }
}
