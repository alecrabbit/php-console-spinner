<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Kernel\Contract;

interface IStrSplitter
{
    public static function split(string $s, ?int $length = null): array;
}
