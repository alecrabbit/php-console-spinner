<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Mixin;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;

trait HasUpdateIntervalWithMethod
{
    public function updateInterval(IIntervalVisitor $intervalVisitor): void
    {
        $this->interval = $this->interval->smallest($intervalVisitor->visit($this));
    }
}
