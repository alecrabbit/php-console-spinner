<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Core\Contract\ISequenceState;

interface IHasSequenceState
{
    public function getState(?float $dt = null): ISequenceState;
}
