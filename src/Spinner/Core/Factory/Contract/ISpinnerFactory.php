<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

interface ISpinnerFactory
{
    public static function createSpinner(IConfig $config = null): ISpinner;

    public static function registerLoopClass(string $class): void;
}
