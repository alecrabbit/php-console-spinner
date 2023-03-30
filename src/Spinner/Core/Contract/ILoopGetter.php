<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Core\Contract;

interface ILoopGetter
{
    /**
     * @return IForeignLoop
     */
    public function getLoop();
}
