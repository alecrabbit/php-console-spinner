<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Contract\IIntervalComponent;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

final class IntervalVisitor implements IIntervalVisitor // Tentative class name
{
    public function visit(IIntervalComponent $container): IInterval // Tentative method name
    {
        $interval = $container->getInterval();
        /** @var IIntervalComponent $component */
        foreach ($container->getIntervalComponents() as $component) {
            $component->accept($this);
            $interval = $interval->smallest($component->getInterval());
        }
        return $interval;
    }
}
