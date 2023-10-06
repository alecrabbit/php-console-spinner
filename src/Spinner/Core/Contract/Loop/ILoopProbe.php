<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;

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
