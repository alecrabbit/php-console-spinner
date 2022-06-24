<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Contract\IntervalComponent;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

final class IntervalVisitor implements IIntervalVisitor
{
    public function visit(IntervalComponent $container): IInterval
    {
        $interval = $container->getInterval();
        /** @var IntervalComponent $component */
        foreach ($container->getIntervalComponents() as $component) {
            $component->accept($this);
            $interval = $interval->smallest($component->getInterval());
        }
        return $interval;
    }
}
