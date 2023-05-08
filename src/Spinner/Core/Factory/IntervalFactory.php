<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;

final class IntervalFactory implements IIntervalFactory
{
    private const DEFAULT_INTERVAL = 1000;

    private static ?IInterval $normalizedDefaultInterval = null;
    private static ?IInterval $normalizedStillInterval = null;

    public function __construct(
        protected IIntervalNormalizer $intervalNormalizer,
    ) {
    }

    public function createNormalized(?int $interval): IInterval
    {
        return
            $interval === null
                ? $this->createStill()
                : $this->intervalNormalizer->normalize(new Interval($interval));
    }

    public function createStill(): IInterval
    {
        if (self::$normalizedStillInterval === null) {
            self::$normalizedStillInterval =
                $this->intervalNormalizer->normalize(
                    new Interval(),
                );
        }
        return self::$normalizedStillInterval;
    }

    public function createDefault(): IInterval
    {
        if (self::$normalizedDefaultInterval === null) {
            self::$normalizedDefaultInterval =
                $this->intervalNormalizer->normalize(
                    new Interval(self::DEFAULT_INTERVAL),
                );
        }

        return self::$normalizedDefaultInterval;
    }
}
