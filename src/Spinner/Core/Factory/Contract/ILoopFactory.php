<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopGetter;
use AlecRabbit\Spinner\Core\Contract\ILoopSignalHandlers;
use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;

interface ILoopFactory
{
    public static function create(): ILoopAdapter|ILoopGetter|ILoopSignalHandlers|ISpinnerAttacher;
}
