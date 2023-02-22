<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Config\Contract\IConfig;
use AlecRabbit\Spinner\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface IFactory
{
    public static function createSpinner(IConfig $config = null): ISpinner;

    public static function getConfigBuilder(): IConfigBuilder;
}
