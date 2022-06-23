<?php
declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Contract\IntervalComponent;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Twirler\Contract\IContainer;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

final class IntervalVisitor implements IIntervalVisitor
{
    public function visit(IntervalComponent $container): IInterval
    {
        /** @var IntervalComponent $component */
        foreach ($container->getIntervalComponents() as $component) {
            $component->accept($this);
        }
        return $container->getInterval();
    }
}
