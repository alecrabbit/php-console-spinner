<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Contract;

interface ILoopProbe extends IProbe
{
    public static function createLoop(): ILoop;
}
