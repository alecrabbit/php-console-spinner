<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\LoopAutoStarter;

interface ILoopAutoStarter
{
    public function setup(ILoop $loop): void;
}
