<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface IFacade
{
    public static function getConfigBuilder(): IConfigBuilder;

    public static function getLoop(): ILoopAdapter;

    public static function createSpinner(IConfig $config = null): ISpinner;
}
