<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;


use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;

final class IntervalNormalizer implements IIntervalNormalizer
{
    public function __construct(
        protected IIntegerNormalizer $integerNormalizer,
    ) {
    }

    public function normalize(IInterval $interval): IInterval
    {
        return
            new Interval(
                $this->integerNormalizer->normalize((int)$interval->toMilliseconds())
            );
    }
}
