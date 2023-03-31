<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IStaticIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntegerNormalizer;

abstract class AStaticIntervalFactory extends ADefaultsAwareClass implements IStaticIntervalFactory
{
    protected static NormalizerMode $normalizerMode = self::NORMALIZER_MODE;

    public static function createDefault(): IInterval
    {
        /** @var null|int $normalized */
        static $normalized = null;

        if (null === $normalized) {
            $normalized = self::normalize(
                self::getDefaults()->getSpinnerSettings()->getInterval()
            );
        }

        return
            new Interval($normalized);
    }

    protected static function normalize(int|IInterval $interval): int
    {
        if ($interval instanceof IInterval) {
            $interval = (int)$interval->toMilliseconds();
        }

        return IntegerNormalizer::normalize($interval);
    }

    public static function createStill(): IInterval
    {
        return new Interval();
    }

    public static function createNormalized(int $interval): IInterval
    {
        return new Interval(self::normalize($interval));
    }

    public static function overrideNormalizerMode(NormalizerMode $mode): void
    {
        self::$normalizerMode = $mode;
        IntegerNormalizer::overrideDivisor($mode->getDivisor());
    }
}
