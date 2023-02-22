<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Loop\Contract;

interface ILoopProbe
{
    public static function isSupported(): bool;

    public static function create(): ILoop;
}
