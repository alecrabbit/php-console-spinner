<?php

declare(strict_types=1);

// 17.02.23

namespace AlecRabbit\Spinner\Core\Contract\Loop\Contract;

use AlecRabbit\Spinner\Contract\IStaticProbe;

interface ILoopProbe extends IStaticProbe
{
    public function createLoop(): ILoop;
}
