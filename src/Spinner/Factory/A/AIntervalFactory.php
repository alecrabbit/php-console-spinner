<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Factory\Contract\IIntervalFactory;

abstract class AIntervalFactory extends ADefaultsAwareClass implements IIntervalFactory
{
    public static function createDefault(): IInterval
    {
        return new Interval(self::getDefaults()->getIntervalMilliseconds());
    }
}
