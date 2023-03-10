<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProcedure;

abstract class APattern implements IPattern
{
    protected const UPDATE_INTERVAL = 1000;

    public function getInterval(): IInterval {
        return
            new Interval(static::UPDATE_INTERVAL);
    }
}