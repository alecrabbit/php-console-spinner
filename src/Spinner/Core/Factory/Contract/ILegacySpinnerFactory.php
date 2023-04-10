<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinner;

interface ILegacySpinnerFactory
{
    public function createSpinner(IConfig $config): ILegacySpinner;
}
