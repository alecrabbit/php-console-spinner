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

    /** @inheritDoc */
    public function isDisabled(): bool
    {
        return !$this->isEnabled();
    }

    public function isEnabled(): bool
    {
        return $this->driverConfig->getDriverMode() === DriverMode::ENABLED;
    }
}
