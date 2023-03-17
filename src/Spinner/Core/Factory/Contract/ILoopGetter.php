<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;

interface ILoopGetter
{
    public static function getLoop(): ILoopAdapter;
}
