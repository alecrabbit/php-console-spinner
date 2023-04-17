<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IUpdatable
{
    /**
     * @param float|null $dt delta time(milliseconds), time passed since last update
     */
    public function update(?float $dt = null): IFrame;
}
