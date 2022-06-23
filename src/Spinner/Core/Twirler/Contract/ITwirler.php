<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Contract\IntervalComponent;

interface ITwirler extends Renderable,
                           IntervalComponent
{
    public function render(): ITwirlerFrame;
}
