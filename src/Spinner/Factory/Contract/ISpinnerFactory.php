<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface ISpinnerFactory
{
    public static function create(string|Contract\ISpinnerConfig|null $classOrConfig = null): ISpinner;
}
