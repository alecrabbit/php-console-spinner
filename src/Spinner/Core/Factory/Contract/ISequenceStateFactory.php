<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;

interface ISequenceStateFactory
{
    public function create(?ISequenceFrame $frame = null, ?ISequenceState $previous = null): ISequenceState;
}
