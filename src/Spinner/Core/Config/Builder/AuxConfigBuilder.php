<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
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
    private ?NormalizerMode $normalizerMode = null;

    /**
     * @inheritDoc
     */
    public function build(): IAuxConfig
    {
        $this->validate();

        return
            new AuxConfig(
                runMethodMode: $this->runMethodMode,
                normalizerMode: $this->normalizerMode,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->runMethodMode === null => throw new LogicException('RunMethodMode is not set.'),
            $this->normalizerMode === null => throw new LogicException('NormalizerMode is not set.'),
            default => null,
        };
    }

    public function withRunMethodMode(RunMethodMode $runMethodMode): IAuxConfigBuilder
    {
        $clone = clone $this;
        $clone->runMethodMode = $runMethodMode;
        return $clone;
    }

    public function withNormalizerMode(NormalizerMode $normalizerMode): IAuxConfigBuilder
    {
        $clone = clone $this;
        $clone->normalizerMode = $normalizerMode;
        return $clone;
    }
}
