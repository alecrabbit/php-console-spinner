<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

interface IFacade
{
    public static function getConfigBuilder(): IConfigBuilder;

    public static function getLoop(): ILoop;

    public static function createSpinner(IConfig $config = null): ISpinner;

    public static function useService(string $id, object|callable|string $service): void;
}
