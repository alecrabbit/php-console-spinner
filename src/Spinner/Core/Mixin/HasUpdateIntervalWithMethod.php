<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Mixin;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;

trait HasUpdateIntervalWithMethod
{
    public function updateIntervalWith(IIntervalVisitor $visitor): void
    {
        $this->interval = $this->interval->smallest($visitor->visit($this));
    }
}
