<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use ArrayObject;
use Traversable;

abstract class APattern implements IPattern
{
    /** @var int */
    protected const UPDATE_INTERVAL = 1000;

    /** @var array */
    protected const PATTERN = ['  ', ' u', 'un', 'nd', 'de', 'ef', 'fi', 'in', 'ne', 'ed', 'd ',];

    public function __construct(
        protected ?int $interval = null,
    ) {
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
            new Interval($this->interval ?? static::UPDATE_INTERVAL);
    }
}
