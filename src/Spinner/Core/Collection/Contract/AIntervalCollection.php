<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

use AlecRabbit\Spinner\Core\Contract\ICycle;
use AlecRabbit\Spinner\Core\Contract\ICycleVisitor;
use AlecRabbit\Spinner\Core\Contract\IIntervalComponent;
use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Cycle;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\HasMethodGetInterval;

abstract class AIntervalCollection extends ACollection implements IIntervalComponent
{
    use HasMethodGetInterval;

    protected Cycle $cycle;

    protected function __construct(
        iterable $elements,
        protected readonly IInterval $interval,
    ) {
        parent::__construct($elements);
        $this->cycle = new Cycle(1);
    }

    public function acceptIntervalVisitor(IIntervalVisitor $intervalVisitor): void
    {
        // Intentionally left blank
    }

    public function acceptCycleVisitor(ICycleVisitor $cycleVisitor): void
    {
        // Intentionally left blank
    }

    public function setCycle(ICycle $cycle): void
    {
        dump(static::class . '::' . __FUNCTION__, $cycle);
        $this->cycle = $cycle;
    }

    public function getIntervalComponents(): iterable
    {
        return []; // No components
    }

}
