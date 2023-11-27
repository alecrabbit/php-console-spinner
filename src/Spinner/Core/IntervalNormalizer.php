<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizer;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;

final readonly class IntervalNormalizer implements IIntervalNormalizer
{
    public function __construct(
        private IIntegerNormalizer $integerNormalizer,
    ) {
    }

    public function normalize(IInterval $interval): IInterval
    {
        return new Interval(
            $this->integerNormalizer->normalize((int)$interval->toMilliseconds())
        );
    }
}
