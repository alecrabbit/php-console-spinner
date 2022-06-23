<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Contract\IntervalComponent;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\HasGetIntervalMethod;

abstract class AIntervalCollection extends ACollection implements IntervalComponent
{
    use HasGetIntervalMethod;

    protected function __construct(
        iterable $elements,
        protected readonly IInterval $interval,
    ) {
        parent::__construct($elements);
    }

    public function updateIntervalWith(IIntervalVisitor $visitor): void
    {
        // Intentionally left blank
    }

    public function getIntervalComponents(): iterable
    {
        return []; // empty
    }

}
