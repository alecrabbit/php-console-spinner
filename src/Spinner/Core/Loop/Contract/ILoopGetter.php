<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Loop\Contract;

use AlecRabbit\Spinner\Core\Contract\IForeignLoop;

interface ILoopGetter
{
    /**
     * @return IForeignLoop
     */
    public function getEventLoop();
}
