<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;

interface ILinkerConfigFactory
{
    public function create(): ILinkerConfig;
}
