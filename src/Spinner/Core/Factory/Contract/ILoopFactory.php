<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;

interface ILoopFactory
{
    public function create(): ILoop;
}
