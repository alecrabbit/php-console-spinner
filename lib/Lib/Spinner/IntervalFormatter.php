<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Lib\Spinner\Contract\IIntervalFormatter;
use AlecRabbit\Spinner\Contract\IHasInterval;

final readonly class IntervalFormatter implements IIntervalFormatter
{
    /**
     * @inheritDoc
     */
    public function format(IHasInterval $object): string
    {
        return sprintf(
            '[%s] Interval: %sms' . PHP_EOL,
            $object::class,
            $object->getInterval()->toMilliseconds()
        );
    }
}
