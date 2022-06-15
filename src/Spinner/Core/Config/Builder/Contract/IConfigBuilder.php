<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

interface IConfigBuilder
{
    public function build(): IConfig
}
