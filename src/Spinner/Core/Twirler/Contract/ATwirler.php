<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Cycle;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptIntervalVisitor;
use AlecRabbit\Spinner\Core\Mixin\ContextAware;
use AlecRabbit\Spinner\Core\Mixin\HasMethodGetInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\TwirlerFrame;

abstract class ATwirler implements ITwirler
{
    use CanAcceptIntervalVisitor;
    use HasMethodGetInterval;
    use ContextAware;

    protected ITwirlerFrame $currentFrame;
    protected IInterval $interval;
    protected Cycle $cycle;

    public function __construct(
        protected readonly IStyleRevolver $styleRevolver,
        protected readonly ICharRevolver $charRevolver,
        protected readonly ICharFrame $leadingSpacer,
        protected readonly ICharFrame $trailingSpacer,
    ) {
        $this->interval = new Interval(null);
        $this->cycle = new Cycle(1);
//        $this->cycle = new Cycle(CycleCalculator::calculate($preferredInterval, $this->interval));
    }

    public function render(): ITwirlerFrame
    {
        // TODO (2022-06-21 12:31) [Alec Rabbit]: [2a3f2116-ddf7-4147-ac73-fd0d0fc6823f]
        if ($this->cycle->completed()) {
            return
                $this->currentFrame =
                    new TwirlerFrame(
                        $this->styleRevolver->next(),
                        $this->charRevolver->next(),
                        $this->leadingSpacer,
                        $this->trailingSpacer,
                    );
        }
        return
            $this->currentFrame;
    }

    public function getIntervalComponents(): iterable
    {
        yield $this->styleRevolver;
        yield $this->charRevolver;
    }

}
