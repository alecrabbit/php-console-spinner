<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

interface IDriverConfigFactory
{
    public function create(): IDriverConfig;
}
