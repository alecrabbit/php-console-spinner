<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IInterval;

interface IIntervalFactory
{
    public static function createDefault(): IInterval;
}
