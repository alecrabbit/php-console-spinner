<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopSetup;

final class LoopSetup implements ILoopSetup
{
    public function __construct(
        protected ILoopConfig $loopConfig,
    ) {
    }

    public function setup(ILoop $loop): void
    {
        if($this->loopConfig->getAutoStartMode() === AutoStartMode::ENABLED) {
            $loop->autoStart();
        }
    }
}
