<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Config\Builder\Contract;

use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;

interface IConfigBuilder
{
    public function build(): IConfig;
}
