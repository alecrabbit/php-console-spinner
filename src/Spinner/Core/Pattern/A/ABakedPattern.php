<?php

declare(strict_types=1);
// 19.04.23
namespace AlecRabbit\Spinner\Core\Pattern\A;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IBakedPattern;
use AlecRabbit\Spinner\Core\Interval;
use Traversable;

abstract readonly class ABakedPattern implements IBakedPattern
{
    public function __construct(
        protected Traversable $frames,
        protected Interval $interval,
    ) {
    }

    public function getFrames(): Traversable
    {
        return $this->frames;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

}
