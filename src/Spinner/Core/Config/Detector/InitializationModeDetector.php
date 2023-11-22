<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Detector;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IInitializationModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;

final readonly class InitializationModeDetector implements IInitializationModeDetector
{
    public function __construct(
        private IOutputConfig $outputConfig,
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->outputConfig->getInitializationMode() === InitializationMode::ENABLED;
    }
}
