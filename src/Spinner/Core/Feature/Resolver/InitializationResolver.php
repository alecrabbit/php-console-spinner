<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Feature\Resolver;

use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IInitializationModeDetector;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IInitializationResolver;

final readonly class InitializationResolver implements IInitializationResolver
{
    public function __construct(
        private IDriverModeDetector $driverModeDetector,
        private IInitializationModeDetector $initializationModeDetector,
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->driverModeDetector->isEnabled() && $this->initializationModeDetector->isEnabled();
    }
}
