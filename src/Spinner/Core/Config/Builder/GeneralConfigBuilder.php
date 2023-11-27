<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IGeneralConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Config\GeneralConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class GeneralConfigBuilder implements IGeneralConfigBuilder
{
    private ?RunMethodMode $runMethodMode = null;

    public function build(): IGeneralConfig
    {
        $this->validate();

        return new GeneralConfig(
            runMethodMode: $this->runMethodMode,
        );
    }

    private function validate(): void
    {
        match (true) {
            $this->runMethodMode === null => throw new LogicException('RunMethodMode is not set.'),
            default => null,
        };
    }

    public function withRunMethodMode(RunMethodMode $runMethodMode): IGeneralConfigBuilder
    {
        $clone = clone $this;
        $clone->runMethodMode = $runMethodMode;
        return $clone;
    }
}
