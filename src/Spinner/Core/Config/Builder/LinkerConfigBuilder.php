<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILinkerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;
use AlecRabbit\Spinner\Core\Config\LinkerConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class LinkerConfigBuilder implements ILinkerConfigBuilder
{
    private ?LinkerMode $linkerMode = null;

    /**
     * @inheritDoc
     */
    public function build(): ILinkerConfig
    {
        $this->validate();

        return
            new LinkerConfig(
                linkerMode: $this->linkerMode,
            );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->linkerMode === null => throw new LogicException('LinkerMode is not set.'),
            default => null,
        };
    }

    public function withLinkerMode(LinkerMode $linkerMode): ILinkerConfigBuilder
    {
        $clone = clone $this;
        $clone->linkerMode = $linkerMode;
        return $clone;
    }
}
