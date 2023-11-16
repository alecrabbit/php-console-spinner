<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Config\Contract\INormalizerConfig;

final readonly class NormalizerConfig implements INormalizerConfig
{
    public function __construct(
        protected NormalizerMode $normalizerMode,
    ) {
    }

    public function getNormalizerMode(): NormalizerMode
    {
        return $this->normalizerMode;
    }

    /**
     * @return class-string<INormalizerConfig>
     */
    public function getIdentifier(): string
    {
        return INormalizerConfig::class;
    }
}
