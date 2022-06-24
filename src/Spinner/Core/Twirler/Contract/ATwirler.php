<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptIntervalVisitor;
use AlecRabbit\Spinner\Core\Mixin\HasMethodGetInterval;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\TwirlerFrame;

abstract class ATwirler implements ITwirler
{
    use CanAcceptIntervalVisitor;
    use HasMethodGetInterval;

    protected ITwirlerFrame $currentFrame;
    protected IInterval $interval;
    protected readonly ICharFrame $leadingSpacer;
    protected readonly ICharFrame $trailingSpacer;

    public function __construct(
        protected readonly IStyleRevolver $styleRevolver,
        protected readonly ICharRevolver $charRevolver,
        ?ICharFrame $leadingSpacer = null,
        ?ICharFrame $trailingSpacer = null,
    ) {
        $this->interval = new Interval(null);
        $this->leadingSpacer = $leadingSpacer ?? CharFrame::createEmpty();
        $this->trailingSpacer = $trailingSpacer ?? new CharFrame(C::SPACE_CHAR, 1);
    }

    public function render(): ITwirlerFrame
    {
        return
            $this->currentFrame =
                new TwirlerFrame(
                    $this->styleRevolver->next(),
                    $this->charRevolver->next(),
                    $this->leadingSpacer,
                    $this->trailingSpacer,
                );
    }

    public function getIntervalComponents(): iterable
    {
        yield $this->charRevolver;
        yield $this->styleRevolver;
    }

}
