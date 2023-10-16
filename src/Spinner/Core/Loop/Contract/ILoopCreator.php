<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Contract\ICreator;

interface ILoopCreator extends ICreator
{
    public function create(): ILoop;
}
