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
    /** @var int */
    protected const UPDATE_INTERVAL = 1000;

    /** @var array<int, string> */
    protected const PATTERN = ['  ', ' u', 'un', 'nd', 'de', 'ef', 'fi', 'in', 'ne', 'ed', 'd ',];

    protected IInterval $interval;
    public function __construct(
        ?int $interval = null,
    ) {
        $this->interval = new Interval($interval ?? static::UPDATE_INTERVAL);
    }

    public function getPattern(): Traversable
    {
        return $this->pattern();
    }

    protected function pattern(): Traversable
    {
        return new ArrayObject(static::PATTERN);
    }

    public function getInterval(): IInterval
    {
        return
            $this->interval;
    }
}
