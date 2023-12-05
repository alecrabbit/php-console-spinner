<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Pattern;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use Traversable;

interface IPattern
{
    public function getInterval(): IInterval;

    /**
     * @return Traversable<IFrame>
     */
    public function getFrames(): Traversable;
}
