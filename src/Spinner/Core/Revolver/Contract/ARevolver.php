<?php
declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;

abstract class ARevolver implements IRevolver
{
    public function __construct(
        protected IInterval $interval,
    )
    {
    }

    public function updateInterval(IIntervalVisitor $visitor): void
    {
        $this->interval = $this->interval->smallest($visitor->visit($this));
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getIntervalComponents(): iterable
    {
        yield $this->collection;
    }
}
