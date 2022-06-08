<?php
declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface IWidthQualifier
{
    public static function qualify(string ...$elements): int;
}
