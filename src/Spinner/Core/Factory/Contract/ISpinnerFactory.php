<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface ISpinnerFactory
{
    public static function create(iterable|string|null|ISpinnerConfig $framesOrConfig = null): ISpinner;

    public static function get(iterable|string|null|ISpinnerConfig $framesOrConfig = null): ISpinner;
}
