<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IGeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Config\GeneralConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class GeneralConfigBuilder implements IGeneralConfigBuilder
{
    private ?ExecutionMode $executionMode = null;

    public function build(): IGeneralConfig
    {
        $this->validate();

        return new GeneralConfig(
            executionMode: $this->executionMode,
        );
    }

    private function validate(): void
    {
        match (true) {
            $this->executionMode === null => throw new LogicException('ExecutionMode is not set.'),
            default => null,
        };
    }

    public function withExecutionMode(ExecutionMode $executionMode): IGeneralConfigBuilder
    {
        $clone = clone $this;
        $clone->executionMode = $executionMode;
        return $clone;
    }
}
