<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;

final readonly class GeneralConfig implements IGeneralConfig
{
    public function __construct(
        protected ExecutionMode $executionMode,
    ) {
    }

    public function getExecutionMode(): ExecutionMode
    {
        return $this->executionMode;
    }

    /**
     * @return class-string<IGeneralConfig>
     */
    public function getIdentifier(): string
    {
        return IGeneralConfig::class;
    }
}
