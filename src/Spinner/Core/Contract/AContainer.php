<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Cycle;
use AlecRabbit\Spinner\Core\CycleVisitor;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptCycleVisitor;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptIntervalVisitor;
use AlecRabbit\Spinner\Core\Mixin\HasMethodGetInterval;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContext;
use AlecRabbit\Spinner\Core\Twirler\TwirlerContext;

abstract class AContainer implements IContainer
{
    use CanAcceptIntervalVisitor;
    use CanAcceptCycleVisitor;
    use HasMethodGetInterval;

    /** @var TwirlerContext[] */
    protected array $contexts = [];
    protected Cycle $cycle;

    public function __construct(
        protected IInterval $interval,
        protected readonly IIntervalVisitor $intervalVisitor,
    ) {
        $this->cycle = new Cycle(1);
    }

    public function add(ITwirler $twirler): ITwirlerContext
    {
        $context = new TwirlerContext($twirler);
        $this->contexts[] = $context;
        return $context;
    }

    public function render(): iterable
    {
        foreach ($this->contexts as $context) {
            yield $context->getTwirler();
        }
    }

    /**
     * @return IIntervalComponent[]
     */
    public function getIntervalComponents(): iterable
    {
        yield from $this->contexts;
    }

    public function getIntervalVisitor(): IIntervalVisitor
    {
        return $this->intervalVisitor;
    }

    public function getCycleVisitor(): ICycleVisitor
    {
        return new CycleVisitor($this->interval);
    }
}
