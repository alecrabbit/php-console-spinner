<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory\Contract;

use AlecRabbit\Spinner\Config\Contract\IConfig;
use AlecRabbit\Spinner\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

interface IFactory
{
    public static function createSpinner(IConfig $config = null): ISpinner;

    public static function getConfigBuilder(): IConfigBuilder;

    public static function getLoop(): ILoop;
}
