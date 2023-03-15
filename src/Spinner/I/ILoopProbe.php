<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\I;

interface ILoopProbe extends IProbe
{
    public static function createLoop(): ILoop;
}
