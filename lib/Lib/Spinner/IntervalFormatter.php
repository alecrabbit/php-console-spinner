<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Lib\Spinner\Contract\IIntervalFormatter;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IInterval;

final readonly class IntervalFormatter implements IIntervalFormatter
{
    /** @inheritDoc */
    public function format(IInterval $interval): string
    {
        return sprintf(
            'Interval: %sms' . PHP_EOL,
            $interval->toMilliseconds()
        );
    }
}
