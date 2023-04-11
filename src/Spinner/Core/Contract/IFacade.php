<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Facade;

interface IFacade
{
    /**
     * @deprecated
     */
    public static function getConfigBuilder(): IConfigBuilder;

    public static function getDefaultsProvider(): IDefaultsProvider;

    public static function getLoop(): ILoop;

    /**
     * @deprecated
     */
    public static function createSpinner(IConfig $config = null): ILegacySpinner;

    public static function useService(string $id, object|callable|string $service): void;

    public static function getDriver(): IDriver;
}
