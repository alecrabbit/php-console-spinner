<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;

final readonly class AuxConfig implements IAuxConfig
{
    public function __construct(
        protected RunMethodMode $runMethodMode,
        protected NormalizerMode $normalizerMode,
    ) {
    }

    public function getRunMethodMode(): RunMethodMode
    {
        return $this->runMethodMode;
    }

    public function getNormalizerMode(): NormalizerMode
    {
        return $this->normalizerMode;
    }

    /**
     * @return class-string<IAuxConfig>
     */
    public function getIdentifier(): string
    {
        return IAuxConfig::class;
    }

    public function getStream(): mixed
    {
        // TODO: Implement getStream() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function getInitializationMode(): InitializationMode
    {
        // TODO: Implement getInitializationMode() method.
        throw new \RuntimeException('Not implemented.');
    }
}
