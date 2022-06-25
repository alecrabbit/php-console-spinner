<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Twirler\Contract\CanAddTwirler;

interface IContainer extends IIntervalComponent
{
    public function render(): iterable;

    public function getIntervalVisitor(): IIntervalVisitor;

    public function getCycleVisitor(): ICycleVisitor;
}
