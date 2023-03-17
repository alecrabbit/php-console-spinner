<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface ISpinnerFactory
{
    public static function createSpinner(IConfig $config = null): ISpinner;
}
