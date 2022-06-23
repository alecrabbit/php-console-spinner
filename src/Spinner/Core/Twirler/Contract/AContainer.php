<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Contract\IntervalComponent;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use WeakMap;

abstract class AContainer implements IContainer
{
    /** @var ITwirler[] */
    protected array $twirlers = [];
    /** @var WeakMap<ITWirler,int> */
    protected WeakMap $twirlersMap;
    protected int $index = 0;

    public function __construct(
        protected IInterval $interval,
    ) {
        $this->twirlersMap = new WeakMap();
    }

    public function addTwirler(ITwirler $twirler): CanAddTwirler
    {
        $this->twirlers[$this->index] = $twirler;
        $this->twirlersMap[$twirler] = $this->index++;
        return $this;
    }

    public function render(): iterable
    {
        yield from $this->twirlers;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function accept(IIntervalVisitor $visitor): void
    {
        $this->interval = $this->interval->smallest($visitor->visit($this));
    }

    /**
     * @return IntervalComponent[]
     */
    public function getIntervalComponents(): iterable
    {
        yield from $this->twirlers;
    }
}
