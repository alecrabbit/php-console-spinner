<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Feature\Resolver;

use AlecRabbit\Spinner\Core\Config\Contract\Detector\IAutoStartModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IAutoStartResolver;

final readonly class AutoStartResolver implements IAutoStartResolver
{
    public function __construct(
        private IDriverModeDetector $driverModeDetector,
        private IAutoStartModeDetector $autoStartModeDetector,
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->driverModeDetector->isEnabled() && $this->autoStartModeDetector->isEnabled();
    }
}
