<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\Pattern\IStylePattern;

final readonly class StylePattern implements IStylePattern
{
    public function __construct(
        private IHasStyleSequenceFrame $frames,
        private IInterval $interval,
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
