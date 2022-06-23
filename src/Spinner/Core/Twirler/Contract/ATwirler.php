<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\TwirlerFrame;

abstract class ATwirler implements ITwirler
{
    protected ITwirlerFrame $currentFrame;
    protected IInterval $interval;

    public function __construct(
        protected readonly IStyleRevolver $styleRevolver,
        protected readonly ICharRevolver $charRevolver,
    ) {
        $this->interval = new Interval(null);
    }

    public function render(): ITwirlerFrame
    {
        return
            $this->currentFrame =
                new TwirlerFrame(
                    $this->styleRevolver->next(),
                    $this->charRevolver->next(),
                );
    }

    public function updateIntervalWith(IIntervalVisitor $visitor): void
    {
        $this->interval = $this->interval->smallest($visitor->visit($this));
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getIntervalComponents(): iterable
    {
//        dump(static::class . '::' . __FUNCTION__);
        yield $this->styleRevolver;
        yield $this->charRevolver;
    }

}
