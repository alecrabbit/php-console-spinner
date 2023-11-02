<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;

final readonly class DriverConfig implements IDriverConfig
{
    public function __construct(
        protected IDriverMessages $driverMessages,
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
}
