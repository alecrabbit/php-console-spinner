<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Asynchronous\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface IFactory
{
    public static function createSpinner(IConfig $config = null): ISpinner;

    public static function getConfigBuilder(): IConfigBuilder;

    public static function getLoop(): ILoop;
}
