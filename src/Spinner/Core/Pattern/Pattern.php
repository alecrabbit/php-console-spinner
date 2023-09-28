<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use Traversable;

final class Pattern implements IPattern
{
    public function __construct(
        protected IInterval $interval,
        protected Traversable $frames,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getFrames(): Traversable
    {
        return $this->frames;
    }
}
