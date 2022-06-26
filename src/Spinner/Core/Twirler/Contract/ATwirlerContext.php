<?php

declare(strict_types=1);
// 25.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntervalComponent;
use AlecRabbit\Spinner\Core\Cycle;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptCycleVisitor;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptIntervalVisitor;
use AlecRabbit\Spinner\Core\Mixin\HasMethodGetInterval;

abstract class ATwirlerContext implements ITwirlerContext, IIntervalComponent
{
    use CanAcceptIntervalVisitor;
    use CanAcceptCycleVisitor;
    use HasMethodGetInterval;

    public ITwirler $twirler;
    protected IInterval $interval;
    protected Cycle $cycle;

    public function __construct(
        ITwirler $twirler,
    ) {
        $this->setTwirler($twirler);
        $this->cycle = new Cycle(1);
    }

    public function getTwirler(): ITwirler
    {
        return $this->twirler;
    }

    public function setTwirler(ITwirler $twirler): void
    {
        $this->twirler = $twirler;
        $this->twirler->setContext($this);
        $this->interval = $twirler->getInterval();
    }

    public function render(): ITwirlerFrame
    {
        return $this->twirler->render();
    }

    public function getIntervalComponents(): iterable
    {
        yield $this->twirler;
    }
}
