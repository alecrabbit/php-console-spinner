<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Contract;

interface ISpinnerFactory
{
    public static function create(string|Contract\ISpinnerConfig|null $classOrConfig = null): Contract\IRotator;

    public static function get(): Contract\IRotator;
}
