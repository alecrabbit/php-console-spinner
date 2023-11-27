<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Detector;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\ILinkerModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;

final readonly class LinkerModeDetector implements ILinkerModeDetector
{
    public function __construct(
        private ILinkerConfig $linkerConfig,
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->linkerConfig->getLinkerMode() === LinkerMode::ENABLED;
    }
}
