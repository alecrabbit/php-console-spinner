<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Detector;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Core\Config\Contract\Detector\IDriverModeDetector;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

final readonly class DriverModeDetector implements IDriverModeDetector
{
    public function __construct(
        private IDriverConfig $driverConfig,
    ) {
    }

    public function isEnabled(): bool
    {
        return dump($this->driverConfig->getDriverMode()) === DriverMode::ENABLED;
    }
}
