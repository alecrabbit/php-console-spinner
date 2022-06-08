<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ISpinnerFactory
{
    public static function create(string|null|ISpinnerConfig $classOrConfig = null): ISpinner;

    public static function get(): ISpinner;
}
