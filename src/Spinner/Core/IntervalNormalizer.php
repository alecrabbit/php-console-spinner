<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;


use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;

final class IntervalNormalizer implements IIntervalNormalizer
{
    protected IIntegerNormalizer $normalizer;

    public function __construct(
        protected NormalizerMode $mode = NormalizerMode::BALANCED,
    ) {
        $this->normalizer = $this->getIntegerNormalizer($mode);
    }

    protected function getIntegerNormalizer(NormalizerMode $mode): IIntegerNormalizer
    {
        return
            new IntegerNormalizer(
                $mode->getDivisor(),
                IInterval::MIN_INTERVAL_MILLISECONDS
            );
    }

    public function normalize(IInterval $interval): IInterval
    {
        return
            new Interval(
                $this->normalizer->normalize((int)$interval->toMilliseconds())
            );
    }
}
