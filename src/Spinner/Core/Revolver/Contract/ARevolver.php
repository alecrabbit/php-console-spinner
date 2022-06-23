<?php
declare(strict_types=1);
// 23.06.22
namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntervalVisitor;
use AlecRabbit\Spinner\Core\Interval\Contract\IInterval;
use AlecRabbit\Spinner\Core\Mixin\HasGetIntervalMethod;
use AlecRabbit\Spinner\Core\Mixin\HasUpdateIntervalWithMethod;

abstract class ARevolver implements IRevolver
{
    use HasUpdateIntervalWithMethod;
    use HasGetIntervalMethod;

    public function __construct(
        protected IInterval $interval,
    )
    {
    }

    public function getIntervalComponents(): iterable
    {
        yield $this->collection;
    }
}
