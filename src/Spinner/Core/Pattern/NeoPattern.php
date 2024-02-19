<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\IHasSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\Pattern\INeoPattern;

final readonly class NeoPattern implements INeoPattern
{
    public function __construct(
        private IHasSequenceFrame $frames,
        private IInterval $interval,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }


    public function getFrame(?float $dt = null): ISequenceFrame
    {
        return $this->frames->getFrame($dt);
    }
}
