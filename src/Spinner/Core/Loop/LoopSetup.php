<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\IDisabledDriverDetector;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;

final readonly class LoopSetup implements ILoopSetup
{
    public function __construct(
        private ILoopConfig $loopConfig,
        private IDisabledDriverDetector $disabledDriverDetector,
    ) {
    }

    public function setup(ILoop $loop): void
    {
        if ($this->isAutoStartEnabled()) {
            $loop->autoStart();
        }
    }

    private function isAutoStartEnabled(): bool
    {
        return $this->driverEnabled() && $this->loopConfig->getAutoStartMode() === AutoStartMode::ENABLED;
    }

    private function driverEnabled(): bool
    {
        return !$this->disabledDriverDetector->isDisabled();
    }
}
