<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Contract\IntervalComponent;

interface IContainer extends CanAddTwirler,
                             IntervalComponent
{
    public function render(): iterable;
}
