<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Probe;

use AlecRabbit\Spinner\Contract\ICreator;

interface IStaticProbe
{
    public static function isSupported(): bool;

    /**
     * @return class-string<ICreator>
     */
    public static function getCreatorClass(): string;
}
