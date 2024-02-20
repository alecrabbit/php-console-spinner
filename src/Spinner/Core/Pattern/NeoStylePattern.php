<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IHasSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\Pattern\INeoStylePattern;

final readonly class NeoStylePattern implements INeoStylePattern
{
    public function __construct(
        private IHasFrame $frames,
        private IInterval $interval
    ) {
    }
    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getFrame(?float $dt = null): IStyleSequenceFrame
    {
        return $this->frames->getFrame($dt);
    }
}
