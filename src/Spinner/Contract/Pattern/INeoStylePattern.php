<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Pattern;

use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;

interface INeoStylePattern extends INeoPattern, IHasStyleSequenceFrame
{
    /**
     * @param float|null $dt delta time(milliseconds), time passed since last update
     */
    public function getFrame(?float $dt = null): IStyleSequenceFrame;
}
