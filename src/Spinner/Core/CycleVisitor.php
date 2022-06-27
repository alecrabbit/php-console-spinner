<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ICycleVisitor;
use AlecRabbit\Spinner\Core\Contract\IIntervalComponent;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval\Interval;

final class CycleVisitor implements ICycleVisitor // Tentative class name
{
    public function __construct(
        protected readonly IInterval $interval = Interval::createDefault(),
    ) {
    }

    public function visit(IIntervalComponent $container): void // Tentative method name
    {
        /** @var IIntervalComponent $component */
        foreach ($container->getIntervalComponents() as $component) {
            $component->acceptCycleVisitor($this);
            $component->setCycle(new Cycle(CycleCalculator::calculate($this->interval, $component->getInterval())));
        }
    }
}
