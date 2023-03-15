<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\ILoop;
use AlecRabbit\Spinner\Contract\ILoopGetter;
use AlecRabbit\Spinner\Contract\ILoopSignalHandlers;
use AlecRabbit\Spinner\Contract\ILoopSpinnerAttach;

interface ILoopFactory
{
    public static function create(): ILoop|ILoopGetter|ILoopSignalHandlers|ILoopSpinnerAttach;
}