<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\HasGetIntervalMethod;
use AlecRabbit\Spinner\Core\Mixin\HasUpdateIntervalWithMethod;
use AlecRabbit\Spinner\Core\Twirler\Contract\CanAddTwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use WeakMap;

abstract class AContainer implements IContainer
{
    use HasUpdateIntervalWithMethod;
    use HasGetIntervalMethod;

    /** @var ITwirler[] */
    protected array $twirlers = [];
    /** @var WeakMap<ITWirler,int> */
    protected WeakMap $twirlersMap;
    protected int $index = 0;

    public function __construct(
        protected IInterval $interval,
        protected readonly IIntervalVisitor $intervalVisitor,
    ) {
        $this->twirlersMap = new WeakMap();
    }

    public function addTwirler(ITwirler $twirler): CanAddTwirler
    {
        $this->twirlers[$this->index] = $twirler;
        $this->twirlersMap[$twirler] = $this->index++;
//        $this->updateInterval($this->intervalVisitor);
        return $this;
    }

    public function render(): iterable
    {
        yield from $this->twirlers;
    }

    /**
     * @return IntervalComponent[]
     */
    public function getIntervalComponents(): iterable
    {
        yield from $this->twirlers;
    }

    public function getIntervalVisitor(): IIntervalVisitor
    {
        return $this->intervalVisitor;
    }
}
