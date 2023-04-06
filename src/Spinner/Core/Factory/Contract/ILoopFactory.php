<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

interface ILoopFactory
{
    public function getLoop(): ILoop;

    public function getLoopSetup(ILoopConfig $loopConfig): ILoopSetup;
}
