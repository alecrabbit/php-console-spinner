<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\I\ILoop;
use AlecRabbit\Spinner\I\ILoopGetter;
use AlecRabbit\Spinner\I\ILoopSignalHandlers;
use AlecRabbit\Spinner\I\ILoopSpinnerAttach;

interface ILoopFactory
{
    public static function create(): ILoop|ILoopGetter|ILoopSignalHandlers|ILoopSpinnerAttach;
}