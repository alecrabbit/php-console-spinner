<?php

declare(strict_types=1);
// 19.04.23
namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Interval;
use Traversable;

abstract readonly class APattern implements IPattern
{
    public function __construct(
        protected Traversable $entries,
        protected Interval $interval,
    ) {
    }

    public function getEntries(): Traversable
    {
        // TODO: Implement getEntries() method.
    }

    public function getInterval(): IInterval
    {
        // TODO: Implement getInterval() method.
    }

}
