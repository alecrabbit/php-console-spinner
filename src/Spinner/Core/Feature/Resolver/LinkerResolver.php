<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Feature\Resolver;

use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\ILinkerModeDetector;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\ILinkerResolver;

final readonly class LinkerResolver implements ILinkerResolver
{
    public function __construct(
        private ILinkerModeDetector $linkerModeDetector,
        private IDriverModeDetector $driverModeDetector,
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->linkerModeDetector->isEnabled() && $this->driverModeDetector->isEnabled();
    }
}
