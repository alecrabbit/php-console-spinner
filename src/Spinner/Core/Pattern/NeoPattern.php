<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\INeoPattern;

final readonly class NeoPattern implements INeoPattern
{
    public function __construct(
        private IHasFrame $frames,
        private IInterval $interval,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }


    public function getFrame(?float $dt = null): IFrame
    {
        return $this->frames->getFrame($dt);
    }
}
