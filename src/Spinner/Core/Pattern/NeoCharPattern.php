<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\INeoCharPattern;

final readonly class NeoCharPattern implements INeoCharPattern
{
    public function __construct(
        private IHasFrame $frames,
        private IInterval $interval,
        private ICharFrameTransformer $transformer,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function getFrame(?float $dt = null): ICharSequenceFrame
    {
        return $this->transformer->transform(
            $this->frames->getFrame($dt)
        );
    }
}
