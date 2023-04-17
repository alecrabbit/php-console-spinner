<?php

declare(strict_types=1);

// 10.03.23

namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Interval;
use ArrayObject;
use Traversable;

abstract class APattern implements IPattern
{
    protected const INTERVAL = 1000;

    protected IInterval $interval;

    public function __construct(
        ?IInterval $interval = null,
    ) {
        $this->interval = $interval ?? $this->defaultInterval();
    }

    public function getEntries(): Traversable
    {
        return $this->entries();
    }

    abstract protected function entries(): Traversable;

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    protected function defaultInterval(): Interval
    {
        return new Interval(static::INTERVAL);
    }
}
