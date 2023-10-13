<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class DriverConfigBuilder implements IDriverConfigBuilder
{
    private ?LinkerMode $linkerMode = null;
    private ?InitializationMode $initializationMode = null;

    /**
     * @inheritDoc
     */
    public function build(): IDriverConfig
    {
        $this->validate();

        return
            new DriverConfig(
                linkerMode: $this->linkerMode,
                initializationMode: $this->initializationMode,
            );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->linkerMode === null => throw new LogicException('LinkerMode is not set.'),
            $this->initializationMode === null => throw new LogicException('InitializationMode is not set.'),
            default => null,
        };
    }

    public function withLinkerMode(LinkerMode $linkerMode): IDriverConfigBuilder
    {
        $clone = clone $this;
        $clone->linkerMode = $linkerMode;
        return $clone;
    }

    public function withInitializationMode(InitializationMode $initializationMode): IDriverConfigBuilder
    {
        $clone = clone $this;
        $clone->initializationMode = $initializationMode;
        return $clone;
    }
}