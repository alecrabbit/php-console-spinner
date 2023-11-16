<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\NormalizerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\INormalizerConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class NormalizerConfigBuilder implements INormalizerConfigBuilder
{
    private ?NormalizerMode $normalizerMode = null;

    /**
     * @inheritDoc
     */
    public function build(): INormalizerConfig
    {
        $this->validate();

        return
            new NormalizerConfig(
                normalizerMode: $this->normalizerMode,
            );
    }

    private function validate(): void
    {
        match (true) {
            $this->normalizerMode === null => throw new LogicException('NormalizerMode is not set.'),
            default => null,
        };
    }

    public function withNormalizerMode(NormalizerMode $normalizerMode): INormalizerConfigBuilder
    {
        $clone = clone $this;
        $clone->normalizerMode = $normalizerMode;
        return $clone;
    }
}
