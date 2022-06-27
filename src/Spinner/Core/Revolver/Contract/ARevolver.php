<?php

declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Core\Cycle;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptCycleVisitor;
use AlecRabbit\Spinner\Core\Mixin\CanAcceptIntervalVisitor;
use AlecRabbit\Spinner\Core\Mixin\HasMethodGetInterval;

abstract class ARevolver implements IRevolver
{
    use CanAcceptIntervalVisitor;
    use CanAcceptCycleVisitor;
    use HasMethodGetInterval;

    protected Cycle $cycle;
    protected mixed $currentElement;

    public function __construct(
        protected IInterval $interval,
    ) {
        $this->cycle = new Cycle(1);
    }

    public function getIntervalComponents(): iterable
    {
        yield $this->collection;
    }

    protected function next(): mixed
    {
        if ($this->cycle->completed()) {
            return $this->currentElement = $this->collection->next();
        }
        return $this->currentElement;
    }
}
