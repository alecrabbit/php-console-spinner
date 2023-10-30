<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

final readonly class DriverConfig implements IDriverConfig
{
    public function __construct(
        protected LinkerMode $linkerMode,
        protected InitializationMode $initializationMode,
    ) {
    }

    public function getLinkerMode(): LinkerMode
    {
        return $this->linkerMode;
    }

    public function getInitializationMode(): InitializationMode
    {
        return $this->initializationMode;
    }

    /**
     * @return class-string<IDriverConfig>
     */
    public function getIdentifier(): string
    {
        return IDriverConfig::class;
    }

    public function getStream(): mixed
    {
        // TODO: Implement getStream() method.
        throw new \RuntimeException('Not implemented.');
    }
}
