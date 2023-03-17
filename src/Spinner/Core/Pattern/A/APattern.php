<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;

abstract class APattern implements IPattern
{
    /** @var int */
    protected const UPDATE_INTERVAL = 1000;

    protected const PATTERN = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '='];

    public function __construct(
        protected ?int $interval = null,
    ) {
    }

    public function getPattern(): \Traversable
    {
        return new \ArrayObject(static::PATTERN);
    }

    public function getInterval(): IInterval
    {
        return
            new Interval($this->interval ?? static::UPDATE_INTERVAL);
    }
}
