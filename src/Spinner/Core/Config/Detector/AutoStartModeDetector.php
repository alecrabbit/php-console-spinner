<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Detector;

use AlecRabbit\Spinner\Contract\Mode\AutoStartMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IAutoStartModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;

final readonly class AutoStartModeDetector implements IAutoStartModeDetector
{
    public function __construct(
        private ILoopConfig $loopConfig,
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->loopConfig->getAutoStartMode() === AutoStartMode::ENABLED;
    }
}
