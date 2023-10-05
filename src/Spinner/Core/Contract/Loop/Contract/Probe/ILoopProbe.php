<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop\Contract\Probe;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;

interface ILoopProbe extends IStaticProbe
{
    /**
     * @return class-string<ILoopCreator>
     */
    public static function getCreatorClass(): string;

    /**
     * @deprecated
     */
    public function createLoop(): ILoop;
}
