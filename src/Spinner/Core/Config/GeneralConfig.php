<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Contract\Mode\RunMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;

final readonly class GeneralConfig implements IGeneralConfig
{
    public function __construct(
        protected RunMethodMode $runMethodMode,
    ) {
    }

    public function getRunMethodMode(): RunMethodMode
    {
        return $this->runMethodMode;
    }

    /**
     * @return class-string<IGeneralConfig>
     */
    public function getIdentifier(): string
    {
        return IGeneralConfig::class;
    }
}
