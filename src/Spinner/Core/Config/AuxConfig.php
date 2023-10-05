<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;

final readonly class AuxConfig implements IAuxConfig
{
    public function __construct(
        protected RunMethodMode $runMethodMode,
        protected NormalizerMethodMode $normalizerMethodMode,
    ) {
    }

    public function getRunMethodMode(): RunMethodMode
    {
        return $this->runMethodMode;
    }

    public function getNormalizerMethodMode(): NormalizerMethodMode
    {
        return $this->normalizerMethodMode;
    }

    /**
     * @return class-string<IAuxConfig>
     */
    public function getIdentifier(): string
    {
        return IAuxConfig::class;
    }
}
