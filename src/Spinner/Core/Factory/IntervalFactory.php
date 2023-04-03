<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;

final class IntervalFactory implements IIntervalFactory
{
    protected const DEFAULT_INTERVAL = 1000;

    public function __construct(
        protected IIntervalNormalizer $intervalNormalizer,
    ) {
    }

    public function createDefault(): IInterval
    {
        /** @var null|IInterval $normalizedDefaultInterval */
        static $normalizedDefaultInterval = null;

        if (null === $normalizedDefaultInterval) {
            $normalizedDefaultInterval =
                $this->intervalNormalizer->normalize(
                    new Interval(self::DEFAULT_INTERVAL),
                );
        }

        return
            $normalizedDefaultInterval;
    }

    public function createStill(): IInterval
    {
        return new Interval();
    }

    public function createNormalized(int $interval): IInterval
    {
        return
            $this->intervalNormalizer->normalize(
                new Interval($interval)
            );
    }

}
