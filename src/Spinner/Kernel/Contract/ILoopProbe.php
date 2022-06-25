<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Contract;

interface ILoopProbe
{
    public static function getPackageName(): string;

    public static function isSupported(): bool;

    public static function getLoop(): ILoop;
}
