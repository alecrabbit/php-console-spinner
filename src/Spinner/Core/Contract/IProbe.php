<?php
declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Contract;

interface IProbe
{
    public static function isSupported(): bool;
}