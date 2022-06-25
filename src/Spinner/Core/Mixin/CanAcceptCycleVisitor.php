<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Mixin;

use AlecRabbit\Spinner\Core\Contract\ICycle;
use AlecRabbit\Spinner\Core\Contract\ICycleVisitor;

trait CanAcceptCycleVisitor
{
    public function acceptCycleVisitor(ICycleVisitor $cycleVisitor): void
    {
        $cycleVisitor->visit($this);
    }

    public function setCycle(ICycle $cycle): void
    {
        $this->cycle = $cycle;
    }
}
