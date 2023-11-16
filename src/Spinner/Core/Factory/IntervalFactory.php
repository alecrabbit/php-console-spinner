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

    private IInterval $normalizedDefault;
    private IInterval $normalizedStill;

    public function __construct(
        protected IIntervalNormalizer $intervalNormalizer,
    ) {
        $this->normalizedDefault =
            $this->intervalNormalizer->normalize(
                new Interval(self::DEFAULT_INTERVAL),
            );
        $this->normalizedStill =
            $this->intervalNormalizer->normalize(
                new Interval(),
            );
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
        return $this->normalizedStill;
    }

    public function createDefault(): IInterval
    {
        return $this->normalizedDefault;
    }
}
