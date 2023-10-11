<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;

interface ILoopProbe extends IStaticProbe
{
    /**
     * @return class-string<ILoopCreator>
     */
    public static function getCreatorClass(): string;
}
