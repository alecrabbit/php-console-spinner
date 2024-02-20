<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Pattern;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasInterval;

interface INeoCharPattern extends INeoPattern, IHasCharSequenceFrame
{
    /**
     * @param float|null $dt delta time(milliseconds), time passed since last update
     */
    public function getFrame(?float $dt = null): ICharSequenceFrame;
}
