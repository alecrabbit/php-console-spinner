<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Pattern;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use Traversable;

interface IPattern extends IHasInterval
{
    /**
     * @return Traversable<ISequenceFrame>
     */
    public function getFrames(): Traversable;
}
