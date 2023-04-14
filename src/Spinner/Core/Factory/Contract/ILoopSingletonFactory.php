<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;

interface ILoopSingletonFactory
{
    public function getLoop(): ILoop;
}
