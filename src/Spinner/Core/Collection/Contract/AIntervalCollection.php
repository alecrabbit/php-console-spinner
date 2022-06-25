<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Collection\Contract;

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

    public function accept(IIntervalVisitor $intervalVisitor): void
    {
        // Intentionally left blank
    }

    public function getIntervalComponents(): iterable
    {
        return []; // No components
    }

}
