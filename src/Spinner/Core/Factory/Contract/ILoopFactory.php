<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\ILoop;

interface ILoopFactory
{
    public static function getLoop(): ILoop;
}
