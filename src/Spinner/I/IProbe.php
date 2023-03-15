<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\I;

interface IProbe
{
    public static function isSupported(): bool;
}