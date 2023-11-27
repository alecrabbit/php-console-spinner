<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;

interface IGeneralConfigFactory
{
    public function create(): IGeneralConfig;
}
