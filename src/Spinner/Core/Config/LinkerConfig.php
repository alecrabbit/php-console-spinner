<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Contract\Mode\LinkerMode;
use AlecRabbit\Spinner\Core\Config\Contract\ILinkerConfig;

final readonly class LinkerConfig implements ILinkerConfig
{
    public function __construct(
        protected LinkerMode $linkerMode,
    ) {
    }

    public function getLinkerMode(): LinkerMode
    {
        return $this->linkerMode;
    }

    /**
     * @return class-string<ILinkerConfig>
     */
    public function getIdentifier(): string
    {
        return ILinkerConfig::class;
    }
}
