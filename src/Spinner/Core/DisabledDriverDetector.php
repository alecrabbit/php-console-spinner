<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDisabledDriverDetector;

final readonly class DisabledDriverDetector implements IDisabledDriverDetector
{
    public function __construct(
        private IDriverConfig $driverConfig,
    ) {
    }

    public function isDisabled(): bool
    {
        return $this->driverConfig->getDriverMode() === DriverMode::DISABLED;
    }
}
