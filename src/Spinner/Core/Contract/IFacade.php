<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;

interface IFacade
{
    public static function getConfigBuilder(): IConfigBuilder;

    public static function getLoop(): ILoopAdapter;

    public static function createSpinner(IConfig $config = null): ISpinner;
}
