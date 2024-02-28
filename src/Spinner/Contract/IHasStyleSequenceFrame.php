<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IHasStyleSequenceFrame extends IHasSequenceFrame
{
    /**
     * @param float|null $dt delta time(milliseconds), time passed since last update
     */
    public function getFrame(?float $dt = null): IStyleSequenceFrame;
}
