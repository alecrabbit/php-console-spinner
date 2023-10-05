<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop;

use AlecRabbit\Spinner\Contract\ICreator;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;

interface ILoopCreator extends ICreator
{
    public static function create(): ILoop;
}
