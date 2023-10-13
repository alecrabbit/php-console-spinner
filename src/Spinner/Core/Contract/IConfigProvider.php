<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

interface IConfigProvider
{
    public function getConfig(): IConfig;
}
