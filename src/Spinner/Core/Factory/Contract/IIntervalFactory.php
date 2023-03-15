<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\I\IInterval;

interface IIntervalFactory
{
    public static function createDefault(): IInterval;
}
