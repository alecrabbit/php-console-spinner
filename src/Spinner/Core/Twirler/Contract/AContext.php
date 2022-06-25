<?php

declare(strict_types=1);
// 25.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntervalComponent;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptIntervalVisitor;
use AlecRabbit\Spinner\Core\Mixin\HasMethodGetInterval;

abstract class AContext implements IContext, IIntervalComponent
{
    use CanAcceptIntervalVisitor;
    use HasMethodGetInterval;

    public ITwirler $twirler;
    protected IInterval $interval;

    public function __construct(
        ITwirler $twirler,
    ) {
        $this->setTwirler($twirler);
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
