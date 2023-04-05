<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Facade;

interface IFacade
{
    public static function getConfigBuilder(): IConfigBuilder;

    public static function getLoop(): ILoopAdapter;

    public static function createSpinner(IConfig $config = null): ISpinner;

    public static function replaceService(string $id, object|callable|string $service): void;
}
