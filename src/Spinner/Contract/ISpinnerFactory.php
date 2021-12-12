<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ISpinnerFactory
{
    public static function create(string $class, ?ISpinnerConfig $config = null): ISpinner;
}
