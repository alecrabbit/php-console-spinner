<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

final readonly class DriverConfig implements IDriverConfig
{
    public function __construct(
        protected LinkerMode $linkerMode,
    ) {
    }

    public function getLinkerMode(): LinkerMode
    {
        return $this->linkerMode;
    }

    /**
     * @return class-string<IDriverConfig>
     */
    public function getIdentifier(): string
    {
        return IDriverConfig::class;
    }
}
