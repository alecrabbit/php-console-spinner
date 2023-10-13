<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\AuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IAuxConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class AuxConfigBuilder implements IAuxConfigBuilder
{
    private ?RunMethodMode $runMethodMode = null;
    private ?NormalizerMethodMode $normalizerMethodMode = null;

    /**
     * @inheritDoc
     */
    public function build(): IAuxConfig
    {
        $this->validate();

        return
            new AuxConfig(
                runMethodMode: $this->runMethodMode,
                normalizerMethodMode: $this->normalizerMethodMode,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->runMethodMode === null => throw new LogicException('RunMethodMode is not set.'),
            $this->normalizerMethodMode === null => throw new LogicException('NormalizerMethodMode is not set.'),
            default => null,
        };
    }

    public function withRunMethodMode(RunMethodMode $runMethodMode): IAuxConfigBuilder
    {
        $clone = clone $this;
        $clone->runMethodMode = $runMethodMode;
        return $clone;
    }

    public function withNormalizerMethodMode(NormalizerMethodMode $normalizerMethodMode): IAuxConfigBuilder
    {
        $clone = clone $this;
        $clone->normalizerMethodMode = $normalizerMethodMode;
        return $clone;
    }
}
