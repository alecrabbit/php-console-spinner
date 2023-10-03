<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

interface IStaticProbe
{
    public static function isSupported(): bool;
}
