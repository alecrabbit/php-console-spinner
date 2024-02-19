<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Core\Contract\ICharSequenceFrame;

interface IHasCharSequenceFrame extends IHasSequenceFrame
{
    /**
     * @param float|null $dt delta time(milliseconds), time passed since last update
     */
    public function getFrame(?float $dt = null): ICharSequenceFrame;
}
