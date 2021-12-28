<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;

interface ISpinnerFactory
{
    public static function create(string $class, ?ISpinnerConfig $config = null): ISpinner;
}
