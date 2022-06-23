<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Contract\IntervalComponent;
use AlecRabbit\Spinner\Core\Interval\Contract\HasInterval;

interface ITwirler extends Renderable,
                           IntervalComponent
{
    public function render(): ITwirlerFrame;
}
