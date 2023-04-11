<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

interface IFacade
{
    public static function getDefaultsProvider(): IDefaultsProvider;

    public static function getLoop(): ILoop;

    public static function useService(string $id, object|callable|string $service): void;

    public static function getDriver(): IDriver;
}
