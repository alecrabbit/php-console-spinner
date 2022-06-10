<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ILoopProbe
{
    public static function getPackageName(): string;

    public static function isSupported(): bool;

    public static function getLoop(): ILoop;
}
