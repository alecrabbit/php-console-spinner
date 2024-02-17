<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use Traversable;

final readonly class Pattern implements IPattern
{
    /**
     * @param IInterval $interval
     * @param Traversable<ISequenceFrame> $frames
     */
    public function __construct(
        private IInterval $interval,
        private Traversable $frames,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    /** @inheritDoc */
    public function getFrames(): Traversable
    {
        return $this->frames;
    }
}
