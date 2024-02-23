<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;

final readonly class IntervalFactory implements IIntervalFactory
{
    private const DEFAULT_INTERVAL = 1000;

    public function __construct(
        protected IIntervalNormalizer $intervalNormalizer,
    ) {
    }

    public function createNormalized(?int $interval): IInterval
    {
        return $interval === null
            ? $this->createStill()
            : $this->intervalNormalizer->normalize(
                new Interval(
                    $this->refineInterval($interval)
                )
            );
    }

    public function createStill(): IInterval
    {
        return $this->intervalNormalizer->normalize(
            new Interval(),
        );
    }

    private function refineInterval(int $interval): int
    {
        return match (true) {
            $interval < IInterval::MIN_INTERVAL_MILLISECONDS => IInterval::MIN_INTERVAL_MILLISECONDS,
            $interval > IInterval::MAX_INTERVAL_MILLISECONDS => IInterval::MAX_INTERVAL_MILLISECONDS,
            default => $interval,
        };
    }

    /** @inheritDoc */
    public function createDefault(): IInterval
    {
        return $this->intervalNormalizer->normalize(
            new Interval(self::DEFAULT_INTERVAL),
        );
    }
}
