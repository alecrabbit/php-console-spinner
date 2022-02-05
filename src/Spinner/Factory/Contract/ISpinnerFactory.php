<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract;

interface ISpinnerFactory
{
    public static function create(string|Contract\ISpinnerConfig|null $classOrConfig = null): Contract\ISpinner;

    public static function get(): Contract\ISpinner;
}
