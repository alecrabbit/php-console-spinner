<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

final readonly class DriverConfig implements IDriverConfig
{
    public function getIdentifier(): string
    {
        return IDriverConfig::class;
    }
}
