<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Contract;

interface IStaticProbe
{
    public static function isAvailable(): bool;
}
