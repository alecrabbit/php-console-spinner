<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IHasSequenceState
{
    public function getState(?float $dt = null): ISequenceState;
}
