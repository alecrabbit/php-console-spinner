<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;

interface ISpinnerFactory
{
    public static function create(string $class, ?ISpinnerConfig $config = null): ISpinner;
}
