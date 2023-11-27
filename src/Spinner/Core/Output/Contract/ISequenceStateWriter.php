<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

use AlecRabbit\Spinner\Contract\IFinalizable;
use AlecRabbit\Spinner\Contract\IInitializable;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;

interface ISequenceStateWriter extends IInitializable, IFinalizable
{
    public function erase(ISequenceState $state): void;

    public function write(ISequenceState $state): void;
}
