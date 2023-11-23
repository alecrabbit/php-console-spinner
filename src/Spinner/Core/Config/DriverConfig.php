<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\DriverMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;

final readonly class DriverConfig implements IDriverConfig
{
    public function __construct(
        private IDriverMessages $driverMessages,
        private DriverMode $driverMode,
    ) {
    }

    public function getIdentifier(): string
    {
        return IDriverConfig::class;
    }

    public function getDriverMessages(): IDriverMessages
    {
        return $this->driverMessages;
    }

    public function getDriverMode(): DriverMode
    {
        return $this->driverMode;
    }
}
