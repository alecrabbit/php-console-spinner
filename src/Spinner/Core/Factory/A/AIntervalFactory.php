<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;

abstract class AIntervalFactory extends ADefaultsAwareClass implements IIntervalFactory
{
    public static function createDefault(): IInterval
    {
        return new Interval(self::getDefaults()->getIntervalMilliseconds());
    }
}
