<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Mixin;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Cycle;
use AlecRabbit\Spinner\Core\CycleCalculator;

trait CanAcceptIntervalVisitor
{
    public function accept(IIntervalVisitor $intervalVisitor): void
    {
        $interval = $this->interval;
        $this->interval = $this->interval->smallest($intervalVisitor->visit($this));
        $this->cycle = new Cycle(CycleCalculator::calculate($this->interval, $interval));
    }
}
