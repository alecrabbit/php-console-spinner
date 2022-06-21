<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface IWidthDefiner
{
    public static function define(string ...$elements): int;
}
