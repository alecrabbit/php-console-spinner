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
use WeakMap;

abstract class AContainer implements IContainer
{
    use CanAcceptIntervalVisitor;
    use CanAcceptCycleVisitor;
    use HasMethodGetInterval;

    /** @var TwirlerContext[] */
    protected array $contexts = [];
    protected WeakMap $contextsMap;
    protected Cycle $cycle;
    protected int $index = 0;

    public function __construct(
        protected IInterval $interval,
        protected readonly IIntervalVisitor $intervalVisitor,
    ) {
        $this->cycle = new Cycle(1);
        $this->contextsMap = new WeakMap();
    }

    public function add(ITwirler $twirler): ITwirlerContext
    {
        $context = new TwirlerContext($twirler);
        $this->contexts[$this->index] = $context;
        $this->contextsMap[$context] = $this->index++;
        return $context;
    }

    public function remove(ITwirlerContext $context): void
    {
        $index = $this->contextsMap[$context];
        unset($this->contexts[$index]);
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
